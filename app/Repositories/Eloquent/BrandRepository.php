<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function getByCompany(int $companyId, array $filters = [])
    {
        $query = $this->model->where('company_id', $companyId);

        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        return $query->latest()->get();
    }

    public function toggleStatus(int $id): bool
    {
        $brand = $this->find($id);
        $brand->is_active = !$brand->is_active;
        $brand->save();
        return $brand->is_active;
    }
}
