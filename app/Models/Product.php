<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'brand_id', 'category_id', 'product_category_id',
        'ar_eu_id', 'ar_uk_id', 'name', 'description', 'intended_use',
        'sku', 'batch_number', 'status', 'submitted_at', 'reviewed_at',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function arEu()
    {
        return $this->belongsTo(ArAddress::class, 'ar_eu_id');
    }

    public function arUk()
    {
        return $this->belongsTo(ArAddress::class, 'ar_uk_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function issues()
    {
        return $this->hasMany(ProductIssue::class);
    }

    public function documents()
    {
        return $this->hasMany(ProductDocument::class);
    }
}
