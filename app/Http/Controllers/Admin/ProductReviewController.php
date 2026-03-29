<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\AdminModerationService;
use App\Support\ApiResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductReviewController extends Controller
{
    public function queue(Request $request): View
    {
        $query = Product::with(['company', 'brand', 'category'])
            ->where('status', ProductStatus::InReview);

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhereHas('company', fn ($c) => $c->where('name', 'like', $term))
                  ->orWhereHas('brand',   fn ($b) => $b->where('name', 'like', $term));
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        $direction = $request->get('sort', 'oldest') === 'newest' ? 'desc' : 'asc';
        $query->orderBy('submitted_at', $direction);

        $products   = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.queue', compact('products', 'categories'));
    }

    public function show(int $product): View
    {
        $product = Product::with([
            'company.user',
            'brand',
            'category',
            'productCategory',
            'images',
            'documents',
            'issues.admin',
            'arEu',
            'arUk',
        ])->findOrFail($product);

        return view('admin.products.review', compact('product'));
    }

    public function markCompliant(int $product, AdminModerationService $service): RedirectResponse
    {
        try {
            $service->markCompliant($product, auth()->id());
            return redirect()->back()->with('success', 'Product marked as compliant.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function markIncompliant(int $product, AdminModerationService $service): RedirectResponse
    {
        try {
            $service->markIncompliant($product, auth()->id());
            return redirect()->back()->with('success', 'Product marked as incompliant.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(int $product, Request $request, AdminModerationService $service): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|min:20',
        ]);

        try {
            $service->reject($product, auth()->id(), $request->reason);
            return redirect()->route('admin.products.queue')->with('success', 'Product rejected successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function addIssue(int $product, Request $request, AdminModerationService $service): RedirectResponse
    {
        $request->validate([
            'issue_text' => 'required|string|max:1000',
        ]);

        try {
            $service->addIssue($product, auth()->id(), $request->issue_text);
            return redirect()->back()->with('success', 'Issue added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function resolveIssue(int $productId, int $issue, AdminModerationService $service): RedirectResponse
    {
        try {
            $service->resolveIssue($issue, auth()->id());
            return redirect()->back()->with('success', 'Issue resolved.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
