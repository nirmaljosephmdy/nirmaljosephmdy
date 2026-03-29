<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'admin_id', 'issue_text', 'is_resolved', 'created_at'
    ];

    public $timestamps = false; // Using primarily created_at, but migration has timestamp? Wait, migration has created_at only per instruction but we used timestamps() in our replacement so it has updated_at too. Wait, if I used timestamp('created_at')->nullable(), then no updated_at. Let me use const UPDATED_AT = null.

    const UPDATED_AT = null;

    protected $casts = [
        'is_resolved' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
