<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price_monthly', 'stripe_price_id',
        'max_products', 'allows_eu_ar', 'allows_uk_ar', 'priority_review',
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'allows_eu_ar' => 'boolean',
        'allows_uk_ar' => 'boolean',
        'priority_review' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
