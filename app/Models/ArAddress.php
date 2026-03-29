<?php

namespace App\Models;

use App\Enums\ArRegion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'region', 'address_line_1', 'city',
        'postcode', 'country', 'contact_email', 'is_active',
    ];

    protected $casts = [
        'region' => ArRegion::class,
        'is_active' => 'boolean',
    ];

    public function euProducts()
    {
        return $this->hasMany(Product::class, 'ar_eu_id');
    }

    public function ukProducts()
    {
        return $this->hasMany(Product::class, 'ar_uk_id');
    }
}
