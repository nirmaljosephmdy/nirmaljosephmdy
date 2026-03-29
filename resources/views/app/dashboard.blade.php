@extends('layouts.app')

@section('title', 'Manufacturer Dashboard')

@section('content')
<div class="dashboard-content-wrapper">
    <!-- Top Row: Subscription and CTA -->
    <div class="dashboard-top-row">
        <!-- Subscription Card -->
        <div class="subscription-card">
            <div class="sub-info-left" style="flex: 1;">
                <div class="card-label-small">Current Subscription</div>

                @if($subscription && $subscription->plan)
                    @php
                        $statusColors = [
                            \App\Enums\SubscriptionStatus::ACTIVE->value    => ['bg' => '#D1FAE5', 'text' => '#059669'],
                            \App\Enums\SubscriptionStatus::CANCELLED->value => ['bg' => '#FEF3C7', 'text' => '#D97706'],
                            \App\Enums\SubscriptionStatus::EXPIRED->value   => ['bg' => '#FEE2E2', 'text' => '#DC2626'],
                            \App\Enums\SubscriptionStatus::INACTIVE->value  => ['bg' => '#F1F5F9', 'text' => '#64748B'],
                        ];
                        $colors = $statusColors[$subscription->status->value] ?? ['bg' => '#F1F5F9', 'text' => '#64748B'];
                    @endphp
                    <div class="sub-title-row" style="display: flex; align-items: center; gap: 12px; margin-bottom: 32px;">
                        <div class="sub-name" style="font-size: 28px; font-weight: 800; color: #0F172A;">
                            {{ $subscription->plan->name }} — £{{ number_format($subscription->plan->price_monthly, 0) }}<span style="font-size: 14px; color: #64748B; font-weight: 500;">/mo</span>
                        </div>
                        <div class="status-badge" style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 999px; display: flex; align-items: center; gap: 6px;">
                            <span class="status-dot" style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                            {{ $subscription->status->label() }}
                        </div>
                    </div>

                    @if($nextBillingDate)
                        <div class="billing-cycle-info" style="margin-top: 24px;">
                            <div class="card-label-small">
                                {{ $subscription->status === \App\Enums\SubscriptionStatus::CANCELLED ? 'Active until' : 'Next billing cycle' }}
                            </div>
                            <div class="billing-date" style="font-size: 16px; font-weight: 700; color: #0F172A;">
                                {{ $nextBillingDate->format('d M Y') }}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="sub-title-row" style="display: flex; align-items: center; gap: 12px; margin-bottom: 32px;">
                        <div class="sub-name" style="font-size: 28px; font-weight: 800; color: #0F172A;">No Active Plan</div>
                        <div class="status-badge" style="background: #F1F5F9; color: #64748B; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 999px; display: flex; align-items: center; gap: 6px;">
                            <span class="status-dot" style="width: 6px; height: 6px; background: currentColor; border-radius: 50%;"></span>
                            Inactive
                        </div>
                    </div>
                @endif

                <a href="{{ route('app.subscription.index') }}" class="manage-link" style="margin-top: 24px; color: #0052D1; text-decoration: none; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    Manage Subscription <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                </a>
            </div>
            <div class="sub-icon-right" style="opacity: 0.1; color: #00183F;">
                <i data-lucide="image" style="width: 80px; height: 80px;"></i>
            </div>
        </div>

        <!-- Register Product CTA -->
        <div class="register-cta-card">
            <div class="cta-icon-btn">
                <i data-lucide="plus" style="width: 24px; height: 24px;"></i>
            </div>
            <h3>Register Product</h3>
            <p>Submit new manufacturing data for EU compliance verification.</p>
            @if(auth()->user()->canCreateProduct())
                <a href="{{ route('app.products.create') }}" class="btn-white">New Submission</a>
            @else
                <a href="{{ route('app.subscription.index') }}" class="btn-white">Upgrade Plan</a>
            @endif
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stat-grid-4">
        <div class="compact-stat-card">
            <h5>Total Products</h5>
            <div class="stat-val-group">
                <span class="stat-big-num">{{ $totalProducts }}</span>
                <span class="stat-unit">Units</span>
            </div>
        </div>
        <div class="compact-stat-card" style="background: #F0F7FF;">
            <h5>In Review</h5>
            <div class="stat-val-group">
                <span class="stat-big-num blue">{{ $inReview }}</span>
                <span class="stat-unit pending">Pending</span>
            </div>
        </div>
        <div class="compact-stat-card">
            <h5>Compliant</h5>
            <div class="stat-val-group">
                <span class="stat-big-num green">{{ $compliant }}</span>
                <span class="stat-unit verified">Verified</span>
            </div>
        </div>
        <div class="compact-stat-card">
            <h5>Rejected</h5>
            <div class="stat-val-group">
                <span class="stat-big-num red">{{ $rejected }}</span>
                <span class="stat-unit issues">Issues</span>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Table and Side Card -->
    <div class="dashboard-bottom-row">
        <!-- Recent Products Section -->
        <div class="recent-products-section">
            <div class="section-header">
                <h2>Recent Products</h2>
                <a href="{{ route('app.products.index') }}" class="view-all-link">View All</a>
            </div>
            <div class="recent-products-table-box">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentProducts as $product)
                            @php
                                $statusClass = match($product->status) {
                                    \App\Enums\ProductStatus::Compliant   => 'compliant',
                                    \App\Enums\ProductStatus::InReview    => 'in-review',
                                    \App\Enums\ProductStatus::Rejected    => 'rejected',
                                    \App\Enums\ProductStatus::Incompliant => 'rejected',
                                    \App\Enums\ProductStatus::Draft       => 'draft',
                                    default => ''
                                };
                                $statusLabel = match($product->status) {
                                    \App\Enums\ProductStatus::Compliant   => 'Compliant',
                                    \App\Enums\ProductStatus::InReview    => 'In Review',
                                    \App\Enums\ProductStatus::Rejected    => 'Rejected',
                                    \App\Enums\ProductStatus::Incompliant => 'Incompliant',
                                    \App\Enums\ProductStatus::Draft       => 'Draft',
                                    default => 'Unknown'
                                };
                            @endphp
                            <tr>
                                <td class="product-name-cell">{{ $product->name }}</td>
                                <td class="category-cell">{{ $product->category->name ?? '—' }}</td>
                                <td><span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td class="date-cell">{{ $product->updated_at->format('d M Y') }}</td>
                                <td class="actions-cell">
                                    <a href="{{ route('app.products.show', $product) }}" style="color: inherit;">
                                        <i data-lucide="eye" class="action-icon"></i>
                                    </a>
                                    <a href="{{ route('app.products.step', [$product, 1]) }}" style="color: inherit;">
                                        <i data-lucide="edit-3" class="action-icon"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 24px; color: #64748B;">
                                    No products yet.
                                    @if(auth()->user()->canCreateProduct())
                                        <a href="{{ route('app.products.create') }}" style="color: #0052D1;">Register your first product.</a>
                                    @else
                                        <a href="{{ route('app.subscription.index') }}" style="color: #0052D1;">Subscribe to get started.</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Side Card: Brands Manager -->
        @if(auth()->user()->hasActiveSubscription())
            <div class="brands-manager-card">
                <div class="lock-box" style="background: #D1FAE5; color: #059669;">
                    <i data-lucide="unlock" style="width: 24px; height: 24px;"></i>
                </div>
                <h3>Brands Manager</h3>
                <p>Manage your brands and product entities across multiple registrations.</p>
                <a href="{{ route('app.brands.index') }}" class="upgrade-prompt-link">
                    Manage Brands <i data-lucide="arrow-up-right" style="width: 18px; height: 18px;"></i>
                </a>
            </div>
        @else
            <div class="brands-manager-card">
                <div class="lock-box">
                    <i data-lucide="lock" style="width: 24px; height: 24px;"></i>
                </div>
                <h3>Brands Manager</h3>
                <p>Active subscription required to manage multiple brands and entities. Upgrade your plan to unlock global brand oversight.</p>
                <a href="{{ route('app.subscription.index') }}" class="upgrade-prompt-link">
                    Upgrade your plan <i data-lucide="arrow-up-right" style="width: 18px; height: 18px;"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
