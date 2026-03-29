<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => \App\Enums\UserRole::class,
            'is_blocked' => 'boolean',
        ];
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    /**
     * Check if user has an active subscription.
     */
    public function hasActiveSubscription(): bool
    {
        $subscription = $this->subscription;

        if (!$subscription) {
            return false;
        }

        return in_array($subscription->status, [\App\Enums\SubscriptionStatus::ACTIVE, \App\Enums\SubscriptionStatus::CANCELLED]) &&
               ($subscription->ends_at === null || $subscription->ends_at->isFuture());
    }

    /**
     * Check if user is allowed to create more products under their current plan.
     */
    public function canCreateProduct(): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $currentProductsCount = \App\Models\Product::where('company_id', $this->company->id ?? 0)->count();
        $maxProducts = $this->subscription->plan->max_products ?? 0;

        return $currentProductsCount < $maxProducts;
    }

    /**
     * Check if user is allowed to use UK AR based on their current plan.
     */
    public function canUseUK_AR(): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        return (bool) ($this->subscription->plan->allows_uk_ar ?? false);
    }
}
