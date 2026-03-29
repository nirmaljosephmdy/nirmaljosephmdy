<?php
namespace App\Services;

use App\Repositories\Contracts\ArAddressRepositoryInterface;

class ArAddressService {
    protected $repo;

    public function __construct(ArAddressRepositoryInterface $repo) { 
        $this->repo = $repo; 
    }

    public function getAll() { 
        return $this->repo->all(); 
    }

    public function getActiveByRegion($region) { 
        return $this->repo->all()->where('is_active', true)->where('region', $region); 
    }

    public function createAr(array $data) { 
        return $this->repo->create($data); 
    }

    public function updateAr($id, array $data) { 
        return $this->repo->update($id, $data); 
    }

    public function deleteAr($id) { 
        return $this->repo->delete($id); 
    }

    public function getPaginated(array $filters = [], int $perPage = 25) { 
        return $this->repo->paginateWithFilters($filters, $perPage); 
    }

    public function getStats() { 
        return $this->repo->getDashboardStats(); 
    }
}