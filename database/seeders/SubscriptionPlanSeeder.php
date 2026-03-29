<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'price_monthly' => 29.00,
                'stripe_price_id' => 'price_1TGHQI44o0i1Ea4RkndHdDvo',
                'max_products' => 5,
                'allows_uk_ar' => false,
                'allows_eu_ar' => true,
                'priority_review' => false,
            ],
            [
                'name' => 'Growth',
                'price_monthly' => 79.00,
                'stripe_price_id' => 'price_1TGHR744o0i1Ea4RRFgejpBl',
                'max_products' => 25,
                'allows_uk_ar' => true,
                'allows_eu_ar' => true,
                'priority_review' => false,
            ],
            [
                'name' => 'Scale',
                'price_monthly' => 199.00,
                'stripe_price_id' => 'price_1TGHRy44o0i1Ea4RMPu57L32',
                'max_products' => 100,
                'allows_uk_ar' => true,
                'allows_eu_ar' => true,
                'priority_review' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}
