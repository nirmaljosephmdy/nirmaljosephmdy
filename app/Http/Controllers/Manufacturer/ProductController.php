<?php

namespace App\Http\Controllers\Manufacturer;

use App\Enums\ArRegion;
use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manufacturer\UpdateProductStep1Request;
use App\Http\Requests\Manufacturer\UpdateProductStep2Request;
use App\Http\Requests\Manufacturer\UpdateProductStep3Request;
use App\Http\Requests\Manufacturer\UpdateProductStep4Request;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\ArAddress;
use App\Models\Category;
use App\Services\ProductService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductService $service)
    {
        $companyId  = auth()->user()->company->id;
        $filters    = $request->only('status', 'category_id');
        $products   = $service->getProductsForCompany($companyId, $filters);
        $categories = Category::where('is_active', true)->get();

        if ($request->expectsJson()) {
            return ApiResponse::success(ProductListResource::collection($products));
        }

        $stats = [
            'total'     => $products->count(),
            'draft'     => $products->where('status', ProductStatus::Draft)->count(),
            'in_review' => $products->where('status', ProductStatus::InReview)->count(),
            'compliant' => $products->where('status', ProductStatus::Compliant)->count(),
        ];

        return view('app.products.index', compact('products', 'stats', 'categories', 'filters'));
    }

    /**
     * Create a blank draft and redirect to step 1.
     */
    public function create(ProductService $service)
    {
        $user        = auth()->user();
        $maxProducts = $user->subscription->plan->max_products ?? 5;

        try {
            $product = $service->createDraft($user->company->id, $maxProducts);
        } catch (\RuntimeException $e) {
            return redirect()->route('app.products.index')->with('error', $e->getMessage());
        }

        return redirect()->route('app.products.step', ['product' => $product->id, 'step' => 1]);
    }

    /**
     * Show a wizard step view.
     */
    public function step(int $product, int $step, ProductService $service)
    {
        $p    = $service->findForCompany($product, auth()->user()->company->id);
        $data = ['product' => $p, 'step' => $step];

        if ($step === 1) {
            $data['categories'] = Category::where('is_active', true)
                ->with(['productCategories' => fn($q) => $q->where('is_active', true)])
                ->get();
        }

        if ($step === 2) {
            $data['brands'] = auth()->user()->company
                ->brands()
                ->where('is_active', true)
                ->get();
        }

        if ($step === 4) {
            $data['eu_addresses'] = ArAddress::where('region', ArRegion::EU)->where('is_active', true)->get();
            $data['uk_addresses'] = auth()->user()->canUseUK_AR()
                ? ArAddress::where('region', ArRegion::UK)->where('is_active', true)->get()
                : collect();
        }

        return view("app.products.create.step-{$step}", $data);
    }

    /** POST step 1 — Classification */
    public function saveStep1(UpdateProductStep1Request $request, int $product, ProductService $service)
    {
        try {
            $p = $service->saveStep1($product, $request->validated(), auth()->user()->company->id);

            return $request->expectsJson()
                ? ApiResponse::success(new ProductResource($p), 'Classification saved.')
                : redirect()->route('app.products.step', ['product' => $product, 'step' => 2]);
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? ApiResponse::error($e->getMessage(), 422)
                : back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /** POST step 2 — Product Details */
    public function saveStep2(UpdateProductStep2Request $request, int $product, ProductService $service)
    {
        try {
            $p = $service->saveStep2($product, $request->validated(), auth()->user()->company->id);

            return $request->expectsJson()
                ? ApiResponse::success(new ProductResource($p), 'Details saved.')
                : redirect()->route('app.products.step', ['product' => $product, 'step' => 3]);
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? ApiResponse::error($e->getMessage(), 422)
                : back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /** POST step 3 — Images */
    public function saveStep3(UpdateProductStep3Request $request, int $product, ProductService $service)
    {
        try {
            $p = $service->saveStep3($product, $request->file('images'), auth()->user()->company->id);

            return $request->expectsJson()
                ? ApiResponse::success(new ProductResource($p), 'Images saved.')
                : redirect()->route('app.products.step', ['product' => $product, 'step' => 4]);
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? ApiResponse::error($e->getMessage(), 422)
                : back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /** POST step 4 — AR Addresses */
    public function saveStep4(UpdateProductStep4Request $request, int $product, ProductService $service)
    {
        try {
            $p = $service->saveStep4(
                $product,
                $request->validated(),
                auth()->user()->company->id,
                auth()->user()->canUseUK_AR()
            );

            return $request->expectsJson()
                ? ApiResponse::success(new ProductResource($p), 'AR addresses saved.')
                : redirect()->route('app.products.step', ['product' => $product, 'step' => 5]);
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? ApiResponse::error($e->getMessage(), 422)
                : back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(int $product, ProductService $service)
    {
        $p = $service->findForCompany($product, auth()->user()->company->id);

        if (request()->expectsJson()) {
            return ApiResponse::success(new ProductResource($p));
        }

        return view('app.products.show', ['product' => $p]);
    }

    public function edit(int $product, ProductService $service)
    {
        // Redirect to step wizard for editing
        return redirect()->route('app.products.step', ['product' => $product, 'step' => 1]);
    }

    public function submit(int $product, ProductService $service)
    {
        try {
            $p = $service->submitProduct($product, auth()->user()->company->id);

            return request()->expectsJson()
                ? ApiResponse::success(new ProductResource($p), 'Product submitted for review.')
                : redirect()->route('app.products.show', $product)->with('success', 'Product submitted for compliance review.');
        } catch (\Exception $e) {
            return request()->expectsJson()
                ? ApiResponse::error($e->getMessage(), 422)
                : back()->withErrors(['submission' => $e->getMessage()]);
        }
    }

    public function resubmit(int $product, ProductService $service)
    {
        try {
            $p = $service->resubmitProduct($product, auth()->user()->company->id);

            return request()->expectsJson()
                ? ApiResponse::success(new ProductResource($p), 'Product resubmitted.')
                : redirect()->route('app.products.show', $product)->with('success', 'Product resubmitted for review.');
        } catch (\Exception $e) {
            return request()->expectsJson()
                ? ApiResponse::error($e->getMessage(), 422)
                : back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
