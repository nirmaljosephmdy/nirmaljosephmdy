<?php
namespace App\Services;
use App\Repositories\Contracts\CompanyRepositoryInterface;
class CompanyService {
    protected $repo;
    public function __construct(CompanyRepositoryInterface $repo) { $this->repo = $repo; }
    public function createCompany(array $data, $userId) { 
        $data['user_id'] = $userId; 
        $data['status'] = 1;
        if (isset($data['logo'])) { $data['logo_path'] = $data['logo']->store('logos', 'public'); } 
        return $this->repo->create($data); 
    }
    public function updateCompany($id, array $data) { 
        $data['status'] = 1;
        if (isset($data['logo'])) { $data['logo_path'] = $data['logo']->store('logos', 'public'); } 
        return $this->repo->update($id, $data); 
    }
}