<?php

namespace App\Repositories\Contracts;

interface SubscriptionRepositoryInterface
{
    public function getActiveSubscription(int $userId);
    public function createOrUpdate(int $userId, array $data);
    public function updateStatusByStripeId(string $stripeSubscriptionId, int $status, ?string $endsAt = null, ?string $cancelledAt = null);
}
