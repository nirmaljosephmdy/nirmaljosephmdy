@extends('layouts.app')

@section('header', 'Subscription Management')

@section('content')
<div class="subscription-required-container">
    <div class="subscription-required-card">
        <div class="lock-icon-container">
            <div class="lock-icon-box">
                <i data-lucide="lock" style="width: 32px; height: 32px;"></i>
                <div class="alert-dot">!</div>
            </div>
        </div>

        <h2 class="required-title">Active Subscription Required</h2>
        
        <p class="required-description">
            You need an active subscription to access this feature. Please subscribe to continue and unlock all the premium compliance tools EUVerify has to offer.
        </p>

        <div class="action-buttons">
            <a href="{{ route('app.subscription.index') }}" class="btn-primary-sub">
                Subscribe Now <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
            </a>
            
            <button onclick="window.history.back()" class="btn-secondary-sub">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i> Go Back
            </button>
        </div>

        <div class="card-footer-info">
            <span class="footer-item">
                <i data-lucide="shield-check" style="width: 14px; height: 14px;"></i> SECURE ACCESS
            </span>
            <span class="separator"></span>
            <span class="footer-item">
                <i data-lucide="check-circle" style="width: 14px; height: 14px;"></i> VERIFIED PORTAL
            </span>
        </div>
    </div>
</div>

<div class="error-status-code">
    STATUS CODE: <span>ERR_SUB_REQD_0403</span>
</div>
@endsection
