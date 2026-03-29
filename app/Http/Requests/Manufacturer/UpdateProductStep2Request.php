<?php

namespace App\Http\Requests\Manufacturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStep2Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'description'  => 'required|string|min:50',
            'intended_use' => 'required|string|max:500',
            'sku'          => 'nullable|string|max:100',
            'batch_number' => 'nullable|string|max:100',
            'brand_id'     => 'nullable|integer|exists:brands,id',
        ];
    }
}
