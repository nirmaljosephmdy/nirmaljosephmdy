<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class UpdateProductCategoryRequest extends FormRequest { public function authorize() { return true; } public function rules() { return ['category_id' => 'required|exists:categories,id', 'name' => 'required|string|max:255', 'description' => 'nullable|string', 'is_active' => 'boolean']; } }