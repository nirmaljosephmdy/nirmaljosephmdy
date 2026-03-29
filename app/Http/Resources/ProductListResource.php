<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name ?? '(Draft)',
            'category'     => $this->category?->name,
            'sub_category' => $this->productCategory?->name,
            'brand'        => $this->brand?->name,
            'status'       => $this->status->name,
            'status_value' => $this->status->value,
            'updated_at'   => $this->updated_at?->toDateString(),
        ];
    }
}
