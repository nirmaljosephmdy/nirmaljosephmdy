<?php

namespace App\Repositories\Eloquent;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->with(['category', 'productCategory', 'brand', 'images', 'documents', 'issues', 'arEu', 'arUk'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }

    public function getByCompany(int $companyId, array $filters = [])
    {
        $query = $this->model
            ->with(['category', 'productCategory', 'brand'])
            ->where('company_id', $companyId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->latest()->get();
    }

    public function countActiveByCompany(int $companyId): int
    {
        return $this->model
            ->where('company_id', $companyId)
            ->where('status', '!=', ProductStatus::Rejected->value)
            ->count();
    }
}
