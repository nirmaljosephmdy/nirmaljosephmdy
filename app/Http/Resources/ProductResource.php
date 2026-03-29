<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'intended_use' => $this->intended_use,
            'sku'          => $this->sku,
            'batch_number' => $this->batch_number,
            'status'       => $this->status->name,
            'status_value' => $this->status->value,
            'submitted_at' => $this->submitted_at?->toDateTimeString(),
            'reviewed_at'  => $this->reviewed_at?->toDateTimeString(),
            'category'     => $this->category?->name,
            'sub_category' => $this->productCategory?->name,
            'brand'        => $this->brand ? new BrandResource($this->brand) : null,
            'ar_eu'        => $this->arEu ? [
                'id'   => $this->arEu->id,
                'name' => $this->arEu->name,
            ] : null,
            'ar_uk'        => $this->arUk ? [
                'id'   => $this->arUk->id,
                'name' => $this->arUk->name,
            ] : null,
            'images'       => $this->images->map(fn($img) => [
                'id'         => $img->id,
                'url'        => asset('storage/' . $img->file_path),
                'is_primary' => $img->is_primary,
            ]),
            'documents'    => $this->documents->map(fn($doc) => [
                'id'            => $doc->id,
                'type'          => $doc->document_type->name,
                'title'         => $doc->title,
                'status'        => $doc->status->name,
                'version'       => $doc->version,
                'admin_note'    => $doc->admin_note,
            ]),
            'issues'       => $this->issues->map(fn($issue) => [
                'id'          => $issue->id,
                'description' => $issue->description,
                'is_resolved' => $issue->is_resolved,
            ]),
            'updated_at'   => $this->updated_at?->toDateTimeString(),
        ];
    }
}
