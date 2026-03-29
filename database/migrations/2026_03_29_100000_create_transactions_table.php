<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();

            // Payment gateway references
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_invoice_id')->nullable()->index();
            $table->string('stripe_checkout_session_id')->nullable()->index();

            // Transaction details
            $table->string('type')->default('subscription'); // subscription, upgrade, downgrade, refund
            $table->string('status')->default(\App\Enums\TransactionStatus::INITIATED->value);
            $table->unsignedInteger('amount');          // in pence/cents
            $table->string('currency', 3)->default('GBP');
            $table->string('description')->nullable();

            // Extra metadata (gateway response, error messages, etc.)
            $table->json('metadata')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
