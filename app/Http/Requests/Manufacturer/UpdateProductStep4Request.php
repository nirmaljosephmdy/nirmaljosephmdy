<?php

namespace App\Http\Requests\Manufacturer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStep4Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ar_eu_id' => 'required|integer|exists:ar_addresses,id',
            'ar_uk_id' => 'nullable|integer|exists:ar_addresses,id',
        ];
    }
}
