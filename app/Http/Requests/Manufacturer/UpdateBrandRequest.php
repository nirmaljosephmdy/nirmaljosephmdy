<?php

namespace App\Http\Requests\Manufacturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = auth()->user()->company->id;
        $brandId   = $this->route('brand');

        return [
            'name'        => [
                'required', 'string', 'max:255',
                "unique:brands,name,{$brandId},id,company_id,{$companyId}",
            ],
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:500',
            'website'     => 'nullable|url|max:255',
            'is_active'   => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Brand name is already taken. Please choose a unique identifier.',
        ];
    }
}