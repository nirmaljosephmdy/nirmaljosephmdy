<?php

namespace App\Repositories\Contracts;

interface BrandRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByCompany(int $companyId, array $filters = []);
    public function toggleStatus(int $id): bool;
}
