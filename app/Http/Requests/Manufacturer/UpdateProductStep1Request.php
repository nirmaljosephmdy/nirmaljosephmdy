<?php

namespace App\Http\Requests\Manufacturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStep1Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'         => 'required|integer|exists:categories,id',
            'product_category_id' => 'required|integer|exists:product_categories,id',
        ];
    }
}
