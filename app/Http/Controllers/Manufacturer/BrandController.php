<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manufacturer\StoreBrandRequest;
use App\Http\Requests\Manufacturer\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Services\BrandService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request, BrandService $service)
    {
        $companyId = auth()->user()->company->id;
        $filters   = $request->only('is_active');
        $brands    = $service->getBrandsForCompany($companyId, $filters);

        if ($request->expectsJson()) {
            return ApiResponse::success(BrandResource::collection($brands));
        }

        $stats = [
            'total'    => $brands->count(),
            'active'   => $brands->where('is_active', true)->count(),
            'inactive' => $brands->where('is_active', false)->count(),
        ];

        return view('app.brands.index', compact('brands', 'stats'));
    }

    public function create()
    {
        return view('app.brands.create');
    }

    public function store(StoreBrandRequest $request, BrandService $service)
    {
        $brand = $service->createBrand($request->validated(), auth()->user()->company->id);

        if ($request->expectsJson()) {
            return ApiResponse::success(new BrandResource($brand), 'Brand created.', 201);
        }

        return redirect()->route('app.brands.index')->with('success', 'Brand created successfully.');
    }

    public function show($id, BrandService $service)
    {
        $brand = $service->getBrandsForCompany(auth()->user()->company->id)
            ->firstWhere('id', (int) $id);

        abort_if(!$brand, 403, 'Brand not found or access denied.');

        if (request()->expectsJson()) {
            return ApiResponse::success(new BrandResource($brand));
        }

        return view('app.brands.show', compact('brand'));
    }

    public function edit($id, BrandService $service)
    {
        $brand = $service->getBrandsForCompany(auth()->user()->company->id)
            ->firstWhere('id', (int) $id);

        abort_if(!$brand, 403, 'Brand not found or access denied.');

        return view('app.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, $id, BrandService $service)
    {
        $brand = $service->updateBrand((int) $id, $request->validated(), auth()->user()->company->id);

        if ($request->expectsJson()) {
            return ApiResponse::success(new BrandResource($brand), 'Brand updated.');
        }

        return redirect()->route('app.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id, BrandService $service)
    {
        $service->deactivateBrand((int) $id, auth()->user()->company->id);

        if (request()->expectsJson()) {
            return ApiResponse::success(null, 'Brand deactivated.');
        }

        return redirect()->route('app.brands.index')->with('success', 'Brand deactivated.');
    }
}
