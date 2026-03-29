<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
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
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function paginateWithDetails(array $filters = [], int $perPage = 10)
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $term = '%' . $filters['search'] . '%';
            $query->where('name', 'like', $term);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('is_active', $filters['status']);
        }

        $categories = $query->with('productCategories')->latest()->paginate($perPage);

        // Dynamically calculate compliance score based on associated products
        foreach ($categories as $category) {
            // Using 1 for Draft, 3 for Compliant based on typical Enum values
            $totalProducts = $category->products()->where('status', '!=', 1)->count();
            $compliantProducts = $category->products()->where('status', 3)->count();
            
            $score = $totalProducts > 0 ? round(($compliantProducts / $totalProducts) * 100, 1) : 0.0;
            $category->setAttribute('compliance_score', $score);
        }

        return $categories;
    }
}
