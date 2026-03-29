<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByCompany(int $companyId, array $filters = []);
    public function countActiveByCompany(int $companyId): int;
}
