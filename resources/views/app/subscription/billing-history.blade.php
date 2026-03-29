@extends('layouts.app')

@section('title', 'Billing History')

@section('content')
<div class="subscription-page-content">

    <div class="sub-breadcrumb">
        EUVerify <span class="sep">/</span>
        <a href="{{ route('app.subscription.index') }}" style="color:inherit;">Subscription & Billing</a>
        <span class="sep">/</span> <span>Billing History</span>
    </div>

    <div class="manage-sub-header">
        <div class="header-text">
            <h1>Billing History</h1>
            <p>A record of all payments and transactions on your account.</p>
        </div>
        <a href="{{ route('app.subscription.index') }}" class="btn-history">
            <i data-lucide="arrow-left" style="width:18px;"></i>
            Back to Subscription
        </a>
    </div>

    <div class="billing-history-table-wrap">
        @if($transactions->isEmpty())
            <div class="bh-empty">
                <i data-lucide="receipt" style="width:40px; color:#CBD5E1;"></i>
                <p>No transactions found.</p>
            </div>
        @else
            <table class="bh-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr>
                            <td class="bh-date">
                                {{ ($tx->paid_at ?? $tx->created_at)->format('d M Y') }}
                            </td>
                            <td>{{ $tx->description ?? '—' }}</td>
                            <td>{{ $tx->plan?->name ?? '—' }}</td>
                            <td class="bh-amount">{{ $tx->formattedAmount() }}</td>
                            <td>
                                <span class="bh-badge bh-badge--{{ $tx->status->color() }}">
                                    {{ $tx->status->label() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($transactions->hasPages())
                <div class="bh-pagination">
                    {{ $transactions->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
