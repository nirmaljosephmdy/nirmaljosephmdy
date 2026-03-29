<?php

namespace App\Repositories\Eloquent;

use App\Models\ArAddress;
use App\Repositories\Contracts\ArAddressRepositoryInterface;

class ArAddressRepository implements ArAddressRepositoryInterface
{
    protected $model;

    public function __construct(ArAddress $model)
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

    public function paginateWithFilters(array $filters = [], int $perPage = 25)
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $term = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('contact_email', 'like', $term)
                  ->orWhere('city', 'like', $term);
            });
        }

        if (isset($filters['region']) && $filters['region'] !== '') {
            $query->where('region', $filters['region']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('is_active', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getDashboardStats()
    {
        $total = $this->model->count();
        $euCount = $this->model->where('region', \App\Enums\ArRegion::EU)->count();
        
        $euPercentage = $total > 0 ? round(($euCount / $total) * 100) : 0;
        $validCount = $this->model->where('is_active', true)->count();
        
        // Updates in last 24 hours
        $updates = $this->model->where('updated_at', '>=', now()->subHours(24))->count();

        return [
            'eu_percentage' => $euPercentage,
            'valid_count' => $validCount,
            'recent_updates' => $updates,
        ];
    }
}
