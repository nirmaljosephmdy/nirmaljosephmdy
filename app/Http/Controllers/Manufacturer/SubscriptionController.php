<?php
namespace App\Http\Controllers\Manufacturer;
use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use App\Http\Requests\Manufacturer\CheckoutSubscriptionRequest;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
class SubscriptionController extends Controller
{
    public function index(Request $request, SubscriptionService $service)
    {
        if ($request->filled('session_id')) {
            try {
                $service->provisionFromCheckoutSession($request->session_id, auth()->id());
                session()->flash('success', 'Payment successful! Your subscription is now active. You now have access to brands and products.');
            } catch (\Exception $e) {
                session()->flash('error', 'Payment was received but we could not activate your subscription. Please contact support.');
                \Illuminate\Support\Facades\Log::error('Checkout session provisioning failed: ' . $e->getMessage());
            }
        }

        $subscription = $service->getActiveSubscription(auth()->id());

        $nextBillingDate = null;
        if ($subscription) {
            if ($subscription->ends_at) {
                $nextBillingDate = $subscription->ends_at;
            } else {
                $latestPayment = \App\Models\Transaction::where('user_id', auth()->id())
                    ->where('status', \App\Enums\TransactionStatus::SUCCESS->value)
                    ->whereNotNull('paid_at')
                    ->latest('paid_at')
                    ->first();

                if ($latestPayment) {
                    $nextBillingDate = $latestPayment->paid_at->addDays(30);
                } elseif ($subscription->starts_at) {
                    $nextBillingDate = $subscription->starts_at->addDays(30);
                }
            }
        }

        return view('app.subscription.index', [
            'subscription'    => $subscription,
            'nextBillingDate' => $nextBillingDate,
            'plans'           => \App\Models\SubscriptionPlan::all(),
        ]);
    }

    public function checkout(CheckoutSubscriptionRequest $request, SubscriptionService $service)
    {
        try {
            $user = auth()->user();
            $url = $service->createCheckoutSession($user->id, $user->email, $request->plan_id);
            
            return $request->expectsJson() 
                ? ApiResponse::success(['url' => $url]) 
                : redirect()->away($url);
        } catch (\Exception $e) {
            return $request->expectsJson() 
                ? ApiResponse::error($e->getMessage()) 
                : redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(SubscriptionService $service)
    {
        // For a full Stripe implementation, we'd call the Stripe API to cancel the subscription
        // For now, this is a placeholder
        return request()->expectsJson() 
            ? ApiResponse::error('Not implemented via dashboard yet. Please contact support.') 
            : redirect()->back()->with('error', 'Not implemented via dashboard yet.');
    }

    public function reactivate(SubscriptionService $service)
    {
        return request()->expectsJson() 
            ? ApiResponse::error('Not implemented via dashboard yet.') 
            : redirect()->back()->with('error', 'Not implemented via dashboard yet.');
    }

    public function billingHistory()
    {
        $transactions = \App\Models\Transaction::forUser(auth()->id())
            ->with('plan')
            ->latest()
            ->paginate(15);

        return view('app.subscription.billing-history', compact('transactions'));
    }

    public function required()
    {
        return view('app.subscription.required');
    }
}