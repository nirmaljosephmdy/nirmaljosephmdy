<?php

namespace App\Services;

use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class BrandService
{
    public function __construct(
        protected BrandRepositoryInterface $repo
    ) {}

    public function getBrandsForCompany(int $companyId, array $filters = [])
    {
        return $this->repo->getByCompany($companyId, $filters);
    }

    public function createBrand(array $data, int $companyId)
    {
        $data['company_id'] = $companyId;

        if (isset($data['logo']) && $data['logo']) {
            $data['logo_path'] = $data['logo']->store('brands', 'public');
        }

        unset($data['logo']);

        return $this->repo->create($data);
    }

    public function updateBrand(int $id, array $data, int $companyId)
    {
        $brand = $this->repo->find($id);

        if ($brand->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this brand.');
        }

        if (isset($data['logo']) && $data['logo']) {
            // Delete old logo
            if ($brand->logo_path) {
                Storage::disk('public')->delete($brand->logo_path);
            }
            $data['logo_path'] = $data['logo']->store('brands', 'public');
        }

        unset($data['logo']);

        return $this->repo->update($id, $data);
    }

    public function deactivateBrand(int $id, int $companyId)
    {
        $brand = $this->repo->find($id);

        if ($brand->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this brand.');
        }

        return $this->repo->update($id, ['is_active' => false]);
    }

    public function toggleBrandStatus(int $id, int $companyId): bool
    {
        $brand = $this->repo->find($id);

        if ($brand->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this brand.');
        }

        return $this->repo->toggleStatus($id);
    }

    public function deleteBrand(int $id, int $companyId)
    {
        $brand = $this->repo->find($id);

        if ($brand->company_id !== $companyId) {
            throw new AuthorizationException('You do not own this brand.');
        }

        if ($brand->logo_path) {
            Storage::disk('public')->delete($brand->logo_path);
        }

        return $this->repo->delete($id);
    }
}
