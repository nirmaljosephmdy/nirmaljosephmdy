@extends('layouts.app')

@section('title', 'Manage Subscription')

@section('content')
<div class="subscription-page-content">
    <!-- Breadcrumbs -->
    <div class="sub-breadcrumb">
        EUVerify <span class="sep">/</span> <span>Subscription & Billing</span>
    </div>

    <!-- Header Actions -->
    <div class="manage-sub-header">
        <div class="header-text">
            <h1>Manage Subscription</h1>
            <p>Review your plan, billing history, and compliance coverage.</p>
        </div>
        <a href="{{ route('app.subscription.billing-history') }}" class="btn-history">
            <i data-lucide="file-text" style="width: 18px;"></i>
            View Billing History
        </a>
    </div>

    <div class="plan-overview-row">
        <!-- Current Plan Card -->
        <div class="overview-card">
            <div class="card-top-badge badge-active">
                <div class="status-dot"></div>
                Active
            </div>
            <div class="card-label">Current Plan</div>
            <h2 class="plan-main-title">{{ $subscription ? $subscription->plan->name : 'No Plan' }}</h2>
            
            <div class="price-display">
                <span class="curr">£</span>
                <span class="amt">{{ $subscription ? number_format($subscription->plan->price_monthly, 0) : '0' }}</span>
                <span class="per">/ month</span>
            </div>

            <div class="card-footer-info">
                <div class="next-billing">
                    <i data-lucide="calendar" style="width: 18px; color: #94A3B8;"></i>
                    <span>Next billing: <strong>{{ $nextBillingDate ? $nextBillingDate->format('d M Y') : 'N/A' }}</strong></span>
                </div>
                <a href="#" class="manage-link">Manage Payment</a>
            </div>
        </div>

    </div>

    <!-- Compare Plans -->
    <h2 class="compare-title">Compare All Plans</h2>

    <div class="pricing-table-container">
        <div class="billing-bg-text">BILLING</div>
        
        <div class="modern-table-box">
            <div class="pricing-grid">
                <!-- Header Row -->
                <div class="grid-cell feature-col-head plan-header-cell">
                    <div style="text-align: left; width: 100%; color: #64748B; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;">Features</div>
                </div>
                
                @php
                    // Order plans for the table: Starter, Growth, Scale
                    $orderedPlans = $plans->sortBy('price_monthly');
                @endphp

                @foreach($orderedPlans as $plan)
                    <div class="grid-cell plan-header-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}">
                        <div class="plan-h-name">{{ $plan->name }}</div>
                        <div class="plan-h-desc">
                            @if($plan->name == 'Starter') Small Operations @endif
                            @if($plan->name == 'Growth') Scale Fast @endif
                            @if($plan->name == 'Scale') Enterprise Grade @endif
                        </div>
                        @if($subscription && $subscription->plan_id == $plan->id)
                            <div class="current-badge">Current</div>
                        @endif
                    </div>
                @endforeach

                <!-- Monthly Price Row -->
                <div class="grid-cell feature-label-cell">Monthly Price</div>
                @foreach($orderedPlans as $plan)
                    <div class="grid-cell value-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}">
                        £{{ number_format((float) $plan->price_monthly, 0) }}
                    </div>
                @endforeach

                <!-- Products Included Row -->
                <div class="grid-cell feature-label-cell">Products Included</div>
                @foreach($orderedPlans as $plan)
                    <div class="grid-cell value-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}">
                        {{ $plan->max_products == 0 ? 'Unlimited' : 'Up to ' . $plan->max_products }}
                    </div>
                @endforeach

                <!-- EU Authorized Rep Row -->
                <div class="grid-cell feature-label-cell">EU Authorized Rep.</div>
                @foreach($orderedPlans as $plan)
                    <div class="grid-cell value-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}">
                        @if($plan->allows_eu_ar)
                            <i data-lucide="check-circle-2" class="check-icon" style="width: 20px;"></i>
                        @else
                            <i data-lucide="x" class="x-icon" style="width: 20px;"></i>
                        @endif
                    </div>
                @endforeach

                <!-- UK Authorized Rep Row -->
                <div class="grid-cell feature-label-cell">UK Authorized Rep.</div>
                @foreach($orderedPlans as $plan)
                    <div class="grid-cell value-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}">
                        @if($plan->allows_uk_ar)
                            <i data-lucide="check-circle-2" class="check-icon" style="width: 20px;"></i>
                        @else
                            <i data-lucide="x" class="x-icon" style="width: 20px;"></i>
                        @endif
                    </div>
                @endforeach

                <!-- Priority Review Row -->
                <div class="grid-cell feature-label-cell">Priority Review</div>
                @foreach($orderedPlans as $plan)
                    <div class="grid-cell value-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}">
                        @if($plan->priority_review)
                            <i data-lucide="check-circle-2" class="check-icon" style="width: 20px;"></i>
                        @else
                            <i data-lucide="x" class="x-icon" style="width: 20px;"></i>
                        @endif
                    </div>
                @endforeach

                <!-- Action Row -->
                <div class="grid-cell" style="border-bottom: none;"></div>
                @foreach($orderedPlans as $plan)
                    <div class="grid-cell action-cell {{ $subscription && $subscription->plan_id == $plan->id ? 'selected-col' : '' }}" style="border-bottom: none;">
                        @if($subscription && $subscription->plan_id == $plan->id)
                            <span class="btn-active-sub">Active Plan</span>
                        @else
                            <form action="{{ route('app.subscription.checkout') }}" method="POST" style="margin: 0; width: 100%;">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                @if(($subscription && $subscription->plan->price_monthly > $plan->price_monthly) || !$subscription)
                                    <button type="submit" class="{{ $subscription ? 'btn-downgrade' : 'btn-subscribe' }}" style="cursor:pointer; width:100%; font-family:inherit; font-size:inherit;">{{ $subscription ? 'Downgrade' : 'Subscribe' }}</button>
                                @else
                                    <button type="submit" class="btn-upgrade-scale" style="border:none; cursor:pointer; width:100%; font-family:inherit; font-size:inherit;">Upgrade to {{ $plan->name }}</button>
                                @endif
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cancellation Section -->
    <div class="cancel-section">
        <div class="cancel-info">
            <div class="cancel-icon-box">
                <i data-lucide="alert-triangle" style="width: 24px;"></i>
            </div>
            <div class="cancel-text">
                <h3>Need to take a break?</h3>
                <p>Cancelling your subscription will pause all compliance monitoring and authorized representative services.</p>
            </div>
        </div>
        <form action="{{ route('app.subscription.cancel') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel your subscription?');">
            @csrf
            <button type="submit" class="btn-cancel-link" style="border:none; cursor:pointer; background:transparent; font-family:inherit; font-size:inherit;">Cancel Subscription</button>
        </form>
    </div>
</div>
@endsection