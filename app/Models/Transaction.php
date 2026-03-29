<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'plan_id',
        'stripe_payment_intent_id',
        'stripe_invoice_id',
        'stripe_checkout_session_id',
        'type',
        'status',
        'amount',
        'currency',
        'description',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'status'   => TransactionStatus::class,
        'metadata' => 'array',
        'paid_at'  => 'datetime',
    ];

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeSuccessful(Builder $query): Builder
    {
        return $query->where('status', TransactionStatus::SUCCESS->value);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', TransactionStatus::PENDING->value);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /** Amount formatted as a human-readable string, e.g. £79.00 */
    public function formattedAmount(): string
    {
        return '£' . number_format($this->amount / 100, 2);
    }

    public function markAs(TransactionStatus $status, array $metadata = []): void
    {
        $this->status = $status;

        if ($metadata) {
            $this->metadata = array_merge($this->metadata ?? [], $metadata);
        }

        if ($status === TransactionStatus::SUCCESS && !$this->paid_at) {
            $this->paid_at = now();
        }

        $this->save();
    }
}
