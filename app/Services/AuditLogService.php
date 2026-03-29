<?php
namespace App\Services;
use App\Repositories\Contracts\AdminAuditLogRepositoryInterface;
class AuditLogService {
 protected $repo;
 public function __construct(AdminAuditLogRepositoryInterface $repo) { $this->repo = $repo; }
 public function log($adminId, $action, $targetType, $targetId, $notes = null) { return $this->repo->create(['admin_id' => $adminId, 'action' => $action, 'target_type' => $targetType, 'target_id' => $targetId, 'notes' => $notes, 'created_at' => now()]); }
}