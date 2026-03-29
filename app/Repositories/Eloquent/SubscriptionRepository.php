<?php

namespace App\Repositories\Eloquent;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Enums\SubscriptionStatus;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function getActiveSubscription(int $userId)
    {
        return Subscription::where('user_id', $userId)
            ->whereIn('status', [SubscriptionStatus::ACTIVE, SubscriptionStatus::CANCELLED])
            ->where(function($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->first();
    }

    public function createOrUpdate(int $userId, array $data)
    {
        return Subscription::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
    
    public function updateStatusByStripeId(string $stripeSubscriptionId, int $status, ?string $endsAt = null, ?string $cancelledAt = null)
    {
        $subscription = Subscription::where('stripe_subscription_id', $stripeSubscriptionId)->first();
        if ($subscription) {
            $subscription->status = $status;
            if ($endsAt) $subscription->ends_at = $endsAt;
            if ($cancelledAt) $subscription->cancelled_at = $cancelledAt;
            $subscription->save();
        }
        return $subscription;
    }

    public function getPlanByStripePriceId(string $priceId)
    {
        return SubscriptionPlan::where('stripe_price_id', $priceId)->first();
    }
}
