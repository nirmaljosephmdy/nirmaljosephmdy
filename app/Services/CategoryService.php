<?php
namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    protected $repo;

    public function __construct(CategoryRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function getPaginated(array $filters = [], int $perPage = 10)
    {
        return $this->repo->paginateWithDetails($filters, $perPage);
    }

    public function createCategory(array $data)
    {
        return $this->repo->create($data);
    }

    public function updateCategory($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteCategory($id)
    {
        $cat = $this->repo->find($id);
        if ($cat->products()->count() > 0) {
            throw new \Exception('Cannot delete, it is already assigned to products');
        }
        return $this->repo->delete($id);
    }
}