<?php

namespace App\Services;

use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Stripe\StripeClient;
use Carbon\Carbon;

class SubscriptionService
{
    protected $subscriptionRepository;
    protected $stripe;

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    public function getActiveSubscription(int $userId)
    {
        return $this->subscriptionRepository->getActiveSubscription($userId);
    }

    public function provisionFromCheckoutSession(string $sessionId, int $userId)
    {
        $session = $this->stripe->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid' || $session->mode !== 'subscription') {
            return;
        }

        // Guard: only provision for the authenticated user
        if ((int) ($session->metadata['user_id'] ?? 0) !== $userId) {
            return;
        }

        $planId = $session->metadata['plan_id'] ?? null;
        $stripeSubscriptionId = $session->subscription ?? null;

        if (!$planId || !$stripeSubscriptionId) {
            return;
        }

        // Skip provisioning if webhook already handled it, but still mark transaction SUCCESS
        $existing = $this->subscriptionRepository->getActiveSubscription($userId);
        if ($existing && $existing->stripe_subscription_id === $stripeSubscriptionId) {
            $transaction = Transaction::where('stripe_checkout_session_id', $sessionId)->first();
            if ($transaction && $transaction->status !== TransactionStatus::SUCCESS) {
                $transaction->subscription_id          = $existing->id;
                $transaction->stripe_payment_intent_id = $session->payment_intent ?? null;
                $transaction->stripe_invoice_id        = $session->invoice ?? null;
                $transaction->markAs(TransactionStatus::SUCCESS);
            }
            return;
        }

        $stripeSub = $this->stripe->subscriptions->retrieve($stripeSubscriptionId);

        $statusMap = [
            'active'   => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'trialing' => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'past_due' => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'canceled' => \App\Enums\SubscriptionStatus::EXPIRED->value,
            'unpaid'   => \App\Enums\SubscriptionStatus::INACTIVE->value,
        ];

        $status = $statusMap[$stripeSub->status] ?? \App\Enums\SubscriptionStatus::INACTIVE->value;

        $subscription = $this->subscriptionRepository->createOrUpdate($userId, [
            'plan_id'                => (int) $planId,
            'stripe_subscription_id' => $stripeSubscriptionId,
            'status'                 => $status,
            'starts_at'              => $stripeSub->current_period_start ? Carbon::createFromTimestamp($stripeSub->current_period_start) : null,
            'ends_at'                => $stripeSub->current_period_end   ? Carbon::createFromTimestamp($stripeSub->current_period_end)   : null,
        ]);

        $transaction = Transaction::where('stripe_checkout_session_id', $sessionId)->first();

        if ($transaction && $transaction->status !== TransactionStatus::SUCCESS) {
            $transaction->subscription_id           = $subscription->id ?? null;
            $transaction->stripe_payment_intent_id  = $session->payment_intent ?? null;
            $transaction->stripe_invoice_id         = $session->invoice ?? null;
            $transaction->markAs(TransactionStatus::SUCCESS);
        }
    }

    public function createCheckoutSession(int $userId, string $userEmail, int $planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);

        if (!$plan->stripe_price_id) {
            throw new \Exception("Stripe Price ID is missing for plan: {$plan->name}");
        }

        $session = $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $plan->stripe_price_id,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('app.subscription.index') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('app.subscription.index'),
            'customer_email' => $userEmail,
            'client_reference_id' => $userId,
            'metadata' => [
                'user_id' => $userId,
                'plan_id' => $plan->id,
            ],
        ]);

        Transaction::create([
            'user_id'                    => $userId,
            'plan_id'                    => $plan->id,
            'stripe_checkout_session_id' => $session->id,
            'type'                       => 'subscription',
            'status'                     => TransactionStatus::INITIATED->value,
            'amount'                     => (int) ($plan->price_monthly * 100), // store in pence
            'currency'                   => 'GBP',
            'description'                => "Subscription to {$plan->name} plan",
        ]);

        return $session->url;
    }

    public function handleWebhook(array $payload)
    {
        $event = $payload['type'];
        $data = $payload['data']['object'];

        switch ($event) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($data);
                break;
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->syncSubscription($data);
                break;
            case 'customer.subscription.deleted':
                $this->subscriptionRepository->updateStatusByStripeId(
                    $data['id'],
                    \App\Enums\SubscriptionStatus::EXPIRED->value,
                    null,
                    Carbon::createFromTimestamp($data['canceled_at'] ?? time())
                );
                break;
        }
    }

    protected function handleCheckoutSessionCompleted(array $session)
    {
        $userId = $session['metadata']['user_id'] ?? null;
        $planId = $session['metadata']['plan_id'] ?? null;
        $stripeSubscriptionId = $session['subscription'] ?? null;

        if (!$userId || !$planId || !$stripeSubscriptionId) {
            return;
        }

        $stripeSub = $this->stripe->subscriptions->retrieve($stripeSubscriptionId);

        $statusMap = [
            'active'   => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'trialing' => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'past_due' => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'canceled' => \App\Enums\SubscriptionStatus::EXPIRED->value,
            'unpaid'   => \App\Enums\SubscriptionStatus::INACTIVE->value,
        ];

        $status = $statusMap[$stripeSub->status] ?? \App\Enums\SubscriptionStatus::INACTIVE->value;

        $subscription = $this->subscriptionRepository->createOrUpdate((int) $userId, [
            'plan_id'                 => (int) $planId,
            'stripe_subscription_id'  => $stripeSubscriptionId,
            'status'                  => $status,
            'starts_at'               => $stripeSub->current_period_start ? Carbon::createFromTimestamp($stripeSub->current_period_start) : null,
            'ends_at'                 => $stripeSub->current_period_end   ? Carbon::createFromTimestamp($stripeSub->current_period_end)   : null,
        ]);

        $transaction = Transaction::where('stripe_checkout_session_id', $session['id'])->first();

        if ($transaction && $transaction->status !== TransactionStatus::SUCCESS) {
            $transaction->subscription_id          = $subscription->id ?? null;
            $transaction->stripe_payment_intent_id = $session['payment_intent'] ?? null;
            $transaction->stripe_invoice_id        = $session['invoice'] ?? null;
            $transaction->markAs(TransactionStatus::SUCCESS);
        }
    }

    protected function syncSubscription(array $stripeSubscription)
    {
        $statusMap = [
            'active' => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'trialing' => \App\Enums\SubscriptionStatus::ACTIVE->value,
            'past_due' => \App\Enums\SubscriptionStatus::ACTIVE->value, // Allow grace period, or map to restricted
            'canceled' => \App\Enums\SubscriptionStatus::EXPIRED->value,
            'unpaid' => \App\Enums\SubscriptionStatus::INACTIVE->value,
        ];

        $status = $statusMap[$stripeSubscription['status']] ?? \App\Enums\SubscriptionStatus::INACTIVE->value;

        // Extract metadata if this is a new sub setup through checkout
        // Stripe doesn't always attach checkout metadata to the subscription itself, 
        // but let's assume either we attach it or it's fetched via checkout.session.completed

        $userId = $stripeSubscription['metadata']['user_id'] ?? null;
        $planId = $stripeSubscription['metadata']['plan_id'] ?? null;
        
        $currentPeriodEnd = $stripeSubscription['current_period_end'] ? Carbon::createFromTimestamp($stripeSubscription['current_period_end']) : null;
        
        $subscription = \App\Models\Subscription::where('stripe_subscription_id', $stripeSubscription['id'])->first();

        // If sub exists, update it
        if ($subscription) {
            $subscription->status = $status;
            $subscription->ends_at = $currentPeriodEnd;
            if ($stripeSubscription['cancel_at_period_end']) {
                $subscription->status = \App\Enums\SubscriptionStatus::CANCELLED->value;
            }
            $subscription->save();
        } else if ($userId && $planId) {
            // New subscription from checkout metadata
            $this->subscriptionRepository->createOrUpdate($userId, [
                'plan_id' => $planId,
                'stripe_subscription_id' => $stripeSubscription['id'],
                'status' => $status,
                'starts_at' => $stripeSubscription['current_period_start'] ? Carbon::createFromTimestamp($stripeSubscription['current_period_start']) : null,
                'ends_at' => $currentPeriodEnd,
            ]);
        }
    }
}