<?php

namespace App\Repositories\Eloquent;

use App\Models\AdminAuditLog;
use App\Repositories\Contracts\AdminAuditLogRepositoryInterface;

class AdminAuditLogRepository implements AdminAuditLogRepositoryInterface
{
    protected $model;

    public function __construct(AdminAuditLog $model)
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
}
