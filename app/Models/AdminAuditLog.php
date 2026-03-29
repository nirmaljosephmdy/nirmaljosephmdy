<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'action', 'target_type', 'target_id', 'notes', 'created_at'
    ];

    const UPDATED_AT = null;

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
