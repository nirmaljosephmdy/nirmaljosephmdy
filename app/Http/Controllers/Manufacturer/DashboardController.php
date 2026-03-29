<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Enums\ProductStatus;
use App\Enums\SubscriptionStatus;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['company', 'subscription.plan']);

        if (!$user->company || $user->company->status == 0) {
            return redirect()->route('app.company.create')->with('notice', 'Please complete your company profile first.');
        }

        $companyId = $user->company->id;

        $totalProducts = Product::where('company_id', $companyId)->count();
        $inReview      = Product::where('company_id', $companyId)->where('status', ProductStatus::InReview)->count();
        $compliant     = Product::where('company_id', $companyId)->where('status', ProductStatus::Compliant)->count();
        $rejected      = Product::where('company_id', $companyId)->where('status', ProductStatus::Rejected)->count();

        $recentProducts = Product::where('company_id', $companyId)
            ->with('category')
            ->latest('updated_at')
            ->limit(5)
            ->get();

        $subscription    = $user->subscription;
        $nextBillingDate = null;

        if ($subscription && $subscription->status === SubscriptionStatus::ACTIVE && $subscription->starts_at) {
            $nextBillingDate = $subscription->starts_at->copy();
            while ($nextBillingDate->isPast()) {
                $nextBillingDate->addMonth();
            }
        } elseif ($subscription && $subscription->status === SubscriptionStatus::CANCELLED && $subscription->ends_at) {
            $nextBillingDate = $subscription->ends_at;
        }

        return view('app.dashboard', compact(
            'totalProducts', 'inReview', 'compliant', 'rejected',
            'recentProducts', 'subscription', 'nextBillingDate'
        ));
    }
}
