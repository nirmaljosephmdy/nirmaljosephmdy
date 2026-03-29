<?php

namespace App\Services;

use App\Enums\ArRegion;
use App\Enums\ProductStatus;
use App\Models\ArAddress;
use App\Models\Brand;
use App\Repositories\Contracts\ProductImageRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repo,
        protected ProductImageRepositoryInterface $imageRepo
    ) {}

    /**
     * STEP 0 — Create an empty draft and return product_id immediately.
     */
    public function createDraft(int $companyId, int $maxProducts)
    {
        $activeCount = $this->repo->countActiveByCompany($companyId);

        if ($activeCount >= $maxProducts) {
            throw new \RuntimeException('Product limit reached for your subscription plan.');
        }

        return $this->repo->create([
            'company_id' => $companyId,
            'status'     => ProductStatus::Draft,
        ]);
    }

    /**
     * STEP 1 — Save classification (category + sub-category).
     */
    public function saveStep1(int $productId, array $data, int $companyId)
    {
        $product = $this->repo->find($productId);
        $this->assertOwnerAndEditable($product, $companyId);

        // Ensure sub-category belongs to category
        $sub = \App\Models\ProductCategory::where('id', $data['product_category_id'])
            ->where('category_id', $data['category_id'])
            ->firstOrFail();

        return $this->repo->update($productId, [
            'category_id'         => $data['category_id'],
            'product_category_id' => $sub->id,
        ]);
    }

    /**
     * STEP 2 — Save product details.
     */
    public function saveStep2(int $productId, array $data, int $companyId)
    {
        $product = $this->repo->find($productId);
        $this->assertOwnerAndEditable($product, $companyId);

        if (!empty($data['brand_id'])) {
            $brand = Brand::where('id', $data['brand_id'])
                ->where('company_id', $companyId)
                ->where('is_active', true)
                ->first();

            if (!$brand) {
                throw ValidationException::withMessages([
                    'brand_id' => 'Selected brand is inactive or does not belong to your company.',
                ]);
            }
        }

        return $this->repo->update($productId, array_filter([
            'name'         => $data['name'] ?? null,
            'description'  => $data['description'] ?? null,
            'intended_use' => $data['intended_use'] ?? null,
            'sku'          => $data['sku'] ?? null,
            'batch_number' => $data['batch_number'] ?? null,
            'brand_id'     => $data['brand_id'] ?? null,
        ], fn($v) => $v !== null));
    }

    /**
     * STEP 3 — Upload product images (1–5).
     */
    public function saveStep3(int $productId, array $images, int $companyId)
    {
        $product = $this->repo->find($productId);
        $this->assertOwnerAndEditable($product, $companyId);

        // Delete existing images before replacing
        foreach ($product->images as $existing) {
            Storage::disk('public')->delete($existing->file_path);
            $existing->delete();
        }

        foreach ($images as $i => $image) {
            $path = $image->store('products/images', 'public');
            $this->imageRepo->create([
                'product_id' => $productId,
                'file_path'  => $path,
                'is_primary' => $i === 0,
                'sort_order' => $i,
            ]);
        }

        return $this->repo->find($productId);
    }

    /**
     * STEP 4 — Save AR address assignments.
     */
    public function saveStep4(int $productId, array $data, int $companyId, bool $canUseUkAr)
    {
        $product = $this->repo->find($productId);
        $this->assertOwnerAndEditable($product, $companyId);

        $euAr = ArAddress::where('id', $data['ar_eu_id'])
            ->where('region', ArRegion::EU)
            ->where('is_active', true)
            ->firstOrFail();

        $updates = ['ar_eu_id' => $euAr->id, 'ar_uk_id' => null];

        if (!empty($data['ar_uk_id'])) {
            if (!$canUseUkAr) {
                throw new AuthorizationException('Your subscription plan does not include UK AR address selection.');
            }

            $ukAr = ArAddress::where('id', $data['ar_uk_id'])
                ->where('region', ArRegion::UK)
                ->where('is_active', true)
                ->firstOrFail();

            $updates['ar_uk_id'] = $ukAr->id;
        }

        return $this->repo->update($productId, $updates);
    }

    /**
     * STEP 6 — Submit product for review.
     */
    public function submitProduct(int $productId, int $companyId)
    {
        $product = $this->repo->find($productId);
        $this->assertOwnerAndEditable($product, $companyId);

        $missing = [];

        if (!$product->name)                 $missing[] = 'Product name';
        if (!$product->description)          $missing[] = 'Description';
        if (!$product->intended_use)         $missing[] = 'Intended use';
        if (!$product->category_id)          $missing[] = 'Category';
        if (!$product->product_category_id)  $missing[] = 'Sub-category';
        if (!$product->ar_eu_id)             $missing[] = 'EU AR address';
        if ($product->images->isEmpty())     $missing[] = 'At least 1 product image';
        if ($product->documents->isEmpty())  $missing[] = 'At least 1 compliance document';

        if (!empty($missing)) {
            throw ValidationException::withMessages([
                'submission' => 'Please complete the following before submitting: ' . implode(', ', $missing) . '.',
            ]);
        }

        return $this->repo->update($productId, [
            'status'       => ProductStatus::InReview,
            'submitted_at' => now(),
        ]);
    }

    /**
     * Resubmit an incompliant product after fixes.
     */
    public function resubmitProduct(int $productId, int $companyId)
    {
        $product = $this->repo->find($productId);

        if ($product->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this product.');
        }

        if ($product->status !== ProductStatus::Incompliant) {
            throw new \RuntimeException('Only incompliant products can be resubmitted.');
        }

        return $this->repo->update($productId, [
            'status'       => ProductStatus::InReview,
            'submitted_at' => now(),
        ]);
    }

    /**
     * General update (for draft / incompliant products only).
     */
    public function updateProduct(int $id, array $data, int $companyId)
    {
        $product = $this->repo->find($id);
        $this->assertOwnerAndEditable($product, $companyId);
        return $this->repo->update($id, $data);
    }

    public function getProductsForCompany(int $companyId, array $filters = [])
    {
        return $this->repo->getByCompany($companyId, $filters);
    }

    public function findForCompany(int $productId, int $companyId)
    {
        $product = $this->repo->find($productId);

        if ($product->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this product.');
        }

        return $product;
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function assertOwnerAndEditable($product, int $companyId): void
    {
        if ($product->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this product.');
        }

        $editable = [ProductStatus::Draft, ProductStatus::Incompliant];

        if (!in_array($product->status, $editable)) {
            throw new \RuntimeException('This product cannot be edited in its current status.');
        }
    }
}
