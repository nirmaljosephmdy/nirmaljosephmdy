<?php
namespace App\Services;

use App\Repositories\Contracts\ProductCategoryRepositoryInterface;

class ProductCategoryService 
{
    protected $repo;

    public function __construct(ProductCategoryRepositoryInterface $repo) 
    { 
        $this->repo = $repo; 
    }

    public function getForCategory(int $categoryId, array $filters = [], int $perPage = 10)
    {
        return $this->repo->paginateForCategory($categoryId, $filters, $perPage);
    }
    
    public function createSubCategory(array $data) 
    { 
        return $this->repo->create($data); 
    }

    public function updateSubCategory($id, array $data) 
    { 
        return $this->repo->update($id, $data); 
    }

    public function deleteSubCategory($id) 
    { 
        $cat = $this->repo->find($id);
        if ($cat->products()->count() > 0) {
            throw new \Exception('Cannot delete, it is already assigned to products');
        }
        return $this->repo->delete($id); 
    }
}