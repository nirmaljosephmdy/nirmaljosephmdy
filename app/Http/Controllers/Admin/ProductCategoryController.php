<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ProductCategoryService;
use App\Http\Requests\Admin\StoreProductCategoryRequest;
use App\Http\Requests\Admin\UpdateProductCategoryRequest;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(Request $request, $categoryId, ProductCategoryService $service)
    {
        $category = Category::findOrFail($categoryId);
        $filters = $request->only(['search', 'status']);
        $subCategories = $service->getForCategory($categoryId, $filters, 10);
        
        return view('admin.categories.sub-categories', compact('category', 'subCategories', 'filters'));
    }

    public function store(StoreProductCategoryRequest $request, $categoryId, ProductCategoryService $service)
    {
        $data = $request->validated();
        $data['category_id'] = $categoryId; // Ensure the nested relation is respected
        
        $cat = $service->createSubCategory($data);
        
        if ($request->expectsJson()) {
            return ApiResponse::success($cat);
        }
        return redirect()->route('admin.categories.sub-categories.index', $categoryId)->with('success', 'Sub-category created successfully.');
    }

    public function update(UpdateProductCategoryRequest $request, $categoryId, $id, ProductCategoryService $service)
    {
        // $request->validated() shouldn't overwrite category_id, it is fixed to the parent
        $cat = $service->updateSubCategory($id, $request->validated());
        
        if ($request->expectsJson()) {
            return ApiResponse::success($cat);
        }
        return redirect()->route('admin.categories.sub-categories.index', $categoryId)->with('success', 'Sub-category updated successfully.');
    }

    public function destroy($categoryId, $id, ProductCategoryService $service)
    {
        try {
            $service->deleteSubCategory($id);
            if (request()->expectsJson()) {
                return ApiResponse::success(null);
            }
            return redirect()->route('admin.categories.sub-categories.index', $categoryId)->with('success', 'Sub-category deleted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400); 
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}