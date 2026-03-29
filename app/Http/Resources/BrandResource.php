<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'logo_url'    => $this->logo_path ? asset('storage/' . $this->logo_path) : null,
            'description' => $this->description,
            'website'     => $this->website,
            'is_active'   => $this->is_active,
            'created_at'  => $this->created_at?->toDateString(),
        ];
    }
}
