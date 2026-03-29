<?php

namespace App\Repositories\Contracts;

interface ArAddressRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function paginateWithFilters(array $filters = [], int $perPage = 25);
    public function getDashboardStats();
}
