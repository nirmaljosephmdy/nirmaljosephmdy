<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, CategoryService $service)
    {
        $filters = $request->only(['search', 'status']);
        $categories = $service->getPaginated($filters, 10);
        
        return view('admin.categories.index', compact('categories', 'filters'));
    }

    public function store(StoreCategoryRequest $request, CategoryService $service)
    {
        $cat = $service->createCategory($request->validated());
        
        if ($request->expectsJson()) {
            return ApiResponse::success($cat);
        }
        
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function update(UpdateCategoryRequest $request, $id, CategoryService $service)
    {
        $cat = $service->updateCategory($id, $request->validated());
        
        if ($request->expectsJson()) {
            return ApiResponse::success($cat);
        }
        
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id, CategoryService $service)
    {
        try {
            $service->deleteCategory($id);
            if (request()->expectsJson()) {
                return ApiResponse::success(null);
            }
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                // Must return 400 or appropriate error code so frontend AJAX can catch it
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400); 
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}