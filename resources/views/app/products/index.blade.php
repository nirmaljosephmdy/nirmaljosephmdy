@extends('layouts.app')
@section('title', 'Products | EUVerify')
@section('header', 'Products')
@section('content')

@php
use App\Enums\ProductStatus;
$statusColors = [
    ProductStatus::Draft->value       => ['bg' => '#F1F5F9', 'text' => '#475569', 'label' => 'DRAFT'],
    ProductStatus::InReview->value    => ['bg' => '#FEF3C7', 'text' => '#92400E', 'label' => 'IN REVIEW'],
    ProductStatus::Compliant->value   => ['bg' => '#D1FAE5', 'text' => '#065F46', 'label' => 'COMPLIANT'],
    ProductStatus::Incompliant->value => ['bg' => '#FEE2E2', 'text' => '#991B1B', 'label' => 'INCOMPLIANT'],
    ProductStatus::Rejected->value    => ['bg' => '#FCE7F3', 'text' => '#9D174D', 'label' => 'REJECTED'],
];
@endphp

<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 700; color: #00183F; margin: 0;">Products</h2>
            <p style="color: #64748B; margin: 4px 0 0 0; font-size: 14px;">
                Manage your EU compliance product portfolio and track verification status.
            </p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <form method="GET" action="{{ route('app.products.index') }}" style="display: flex; gap: 8px;">
                <select name="status" onchange="this.form.submit()"
                    style="padding: 8px 14px; border: 1px solid #E2E8F0; border-radius: 8px; background: #fff; color: #374151; font-size: 14px; cursor: pointer;">
                    <option value="">All Statuses</option>
                    @foreach(ProductStatus::cases() as $s)
                        <option value="{{ $s->value }}" {{ request('status') == $s->value ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                <select name="category_id" onchange="this.form.submit()"
                    style="padding: 8px 14px; border: 1px solid #E2E8F0; border-radius: 8px; background: #fff; color: #374151; font-size: 14px; cursor: pointer;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('app.products.create') }}"
               style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Create Product
            </a>
        </div>
    </div>
</div>

{{-- Stats Row --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">TOTAL PRODUCTS</p>
        <span style="font-size: 36px; font-weight: 700; color: #00183F;">{{ $stats['total'] }}</span>
    </div>
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">COMPLIANT</p>
        <span style="font-size: 36px; font-weight: 700; color: #10B981;">{{ $stats['compliant'] }}</span>
    </div>
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">IN REVIEW</p>
        <span style="font-size: 36px; font-weight: 700; color: #F59E0B;">{{ $stats['in_review'] }}</span>
    </div>
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">DRAFTS</p>
        <span style="font-size: 36px; font-weight: 700; color: #64748B;">{{ $stats['draft'] }}</span>
    </div>
</div>

{{-- Product Table --}}
<div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid #E2E8F0; background: #F8FAFC;">
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">PRODUCT NAME</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">CATEGORY</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">STATUS</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">LAST UPDATED</th>
                <th style="padding: 12px 20px; text-align: right; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            @php $sc = $statusColors[$product->status->value] ?? ['bg' => '#F1F5F9', 'text' => '#475569', 'label' => strtoupper($product->status->name)]; @endphp
            <tr style="border-bottom: 1px solid #F1F5F9;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='#fff'">
                <td style="padding: 16px 20px;">
                    <div style="font-weight: 600; color: #0F172A; font-size: 14px;">{{ $product->name ?? '(Draft)' }}</div>
                    @if($product->sku)
                        <div style="color: #94A3B8; font-size: 12px; margin-top: 2px;">SKU: {{ $product->sku }}</div>
                    @endif
                </td>
                <td style="padding: 16px 20px; color: #374151; font-size: 14px;">
                    {{ $product->category?->name ?? '—' }}
                    @if($product->productCategory)
                        <div style="color: #94A3B8; font-size: 12px;">{{ $product->productCategory->name }}</div>
                    @endif
                </td>
                <td style="padding: 16px 20px;">
                    <span style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em;">
                        {{ $sc['label'] }}
                    </span>
                </td>
                <td style="padding: 16px 20px; color: #64748B; font-size: 14px;">
                    {{ $product->updated_at->format('M d, Y') }}
                </td>
                <td style="padding: 16px 20px; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <a href="{{ route('app.products.show', $product->id) }}"
                           style="display: inline-flex; align-items: center; gap: 4px; background: #F1F5F9; color: #374151; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500;">
                            <i data-lucide="eye" style="width: 13px; height: 13px;"></i> View
                        </a>
                        @if(in_array($product->status, [\App\Enums\ProductStatus::Draft, \App\Enums\ProductStatus::Incompliant]))
                        <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 1]) }}"
                           style="display: inline-flex; align-items: center; gap: 4px; background: #EFF6FF; color: #1D4ED8; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500;">
                            <i data-lucide="pencil" style="width: 13px; height: 13px;"></i> Edit
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 48px; text-align: center; color: #94A3B8;">
                    <i data-lucide="package" style="width: 40px; height: 40px; margin-bottom: 12px; opacity: 0.4;"></i>
                    <p style="margin: 0; font-size: 14px;">No products yet. <a href="{{ route('app.products.create') }}" style="color: #0052D1; font-weight: 600;">Create your first product</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding: 14px 20px; border-top: 1px solid #E2E8F0;">
        <span style="font-size: 13px; color: #64748B; font-weight: 500;">SHOWING {{ $products->count() }} OF {{ $stats['total'] }} PRODUCTS</span>
    </div>
</div>

@endsection
