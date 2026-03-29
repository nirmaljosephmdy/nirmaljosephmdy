@extends('layouts.app')
@section('title', ($product->name ?? 'Product') . ' | EUVerify')
@section('header', 'Products')
@section('content')

@php
use App\Enums\ProductStatus;
$statusMap = [
    ProductStatus::Draft->value       => ['bg' => '#F1F5F9', 'text' => '#475569', 'label' => 'DRAFT'],
    ProductStatus::InReview->value    => ['bg' => '#FEF3C7', 'text' => '#92400E', 'label' => 'IN REVIEW'],
    ProductStatus::Compliant->value   => ['bg' => '#D1FAE5', 'text' => '#065F46', 'label' => 'COMPLIANT'],
    ProductStatus::Incompliant->value => ['bg' => '#FEE2E2', 'text' => '#991B1B', 'label' => 'INCOMPLIANT'],
    ProductStatus::Rejected->value    => ['bg' => '#FCE7F3', 'text' => '#9D174D', 'label' => 'REJECTED'],
];
$sc = $statusMap[$product->status->value] ?? $statusMap[ProductStatus::Draft->value];
$canEdit = in_array($product->status, [ProductStatus::Draft, ProductStatus::Incompliant]);
@endphp

<div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B; margin-bottom: 24px;">
    <a href="{{ route('app.products.index') }}" style="color: #64748B; text-decoration: none;">Products</a>
    <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
    <span style="color: #0052D1; font-weight: 500;">{{ $product->name ?? 'Draft Product' }}</span>
</div>

{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px;">
    <div>
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 6px;">
            <h2 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0;">{{ $product->name ?? 'Untitled Product' }}</h2>
            <span style="background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em;">{{ $sc['label'] }}</span>
        </div>
        <p style="color: #64748B; margin: 0; font-size: 14px;">
            {{ $product->category?->name }} {{ $product->productCategory ? '— ' . $product->productCategory->name : '' }}
            @if($product->sku) · SKU: {{ $product->sku }} @endif
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        @if($canEdit)
            <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 1]) }}"
               style="display: flex; align-items: center; gap: 6px; padding: 10px 18px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                <i data-lucide="pencil" style="width: 14px; height: 14px;"></i> Edit Product
            </a>
        @endif
        @if($product->status === ProductStatus::Draft)
            <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 6]) }}"
               style="display: flex; align-items: center; gap: 6px; padding: 10px 18px; background: #00183F; border-radius: 8px; color: #fff; text-decoration: none; font-weight: 600; font-size: 14px;">
                <i data-lucide="send" style="width: 14px; height: 14px;"></i> Review &amp; Submit
            </a>
        @elseif($product->status === ProductStatus::Incompliant)
            <form method="POST" action="{{ route('app.products.resubmit', $product->id) }}" style="display: inline;">
                @csrf
                <button type="submit"
                    style="display: flex; align-items: center; gap: 6px; padding: 10px 18px; background: #10B981; border: none; border-radius: 8px; color: #fff; font-weight: 600; font-size: 14px; cursor: pointer;">
                    <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i> Resubmit for Review
                </button>
            </form>
        @endif
    </div>
</div>

@if($product->status === ProductStatus::Incompliant && $product->issues->isNotEmpty())
    <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
            <i data-lucide="alert-circle" style="width: 18px; height: 18px; color: #DC2626;"></i>
            <h4 style="font-size: 14px; font-weight: 700; color: #991B1B; margin: 0;">Compliance Issues — Action Required</h4>
        </div>
        @foreach($product->issues->where('is_resolved', false) as $issue)
            <p style="font-size: 13px; color: #991B1B; margin: 0 0 6px 0; padding-left: 12px; border-left: 3px solid #DC2626;">{{ $issue->description }}</p>
        @endforeach
    </div>
@endif

@if($product->status === ProductStatus::Rejected)
    <div style="background: #FCE7F3; border: 1px solid #F9A8D4; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <i data-lucide="x-circle" style="width: 18px; height: 18px; color: #9D174D;"></i>
            <h4 style="font-size: 14px; font-weight: 700; color: #9D174D; margin: 0;">Product Rejected</h4>
        </div>
        <p style="font-size: 13px; color: #9D174D; margin: 0;">This product has been permanently rejected and cannot be resubmitted.</p>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">

    {{-- Left: Product details --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
            <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #374151; margin: 0 0 16px 0;">Product Details</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">BATCH NUMBER</p>
                    <p style="font-size: 14px; font-weight: 500; color: #0F172A; margin: 0;">{{ $product->batch_number ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">BRAND</p>
                    <p style="font-size: 14px; font-weight: 500; color: #0F172A; margin: 0;">{{ $product->brand?->name ?? 'None' }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">EU AR</p>
                    <p style="font-size: 14px; font-weight: 500; color: #0F172A; margin: 0;">{{ $product->arEu?->name ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">UK AR</p>
                    <p style="font-size: 14px; font-weight: 500; color: #0F172A; margin: 0;">{{ $product->arUk?->name ?? 'Not assigned' }}</p>
                </div>
                <div style="grid-column: span 2;">
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 4px 0;">INTENDED USE</p>
                    <p style="font-size: 14px; color: #374151; margin: 0;">{{ $product->intended_use ?? '—' }}</p>
                </div>
                <div style="grid-column: span 2;">
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 4px 0;">DESCRIPTION</p>
                    <p style="font-size: 14px; color: #374151; margin: 0; line-height: 1.6;">{{ $product->description ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Images --}}
        @if($product->images->isNotEmpty())
        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
            <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #374151; margin: 0 0 16px 0;">Product Images</h4>
            <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                @foreach($product->images as $img)
                    <div style="position: relative;">
                        <img src="{{ asset('storage/' . $img->file_path) }}" alt="Product image"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid {{ $img->is_primary ? '#0052D1' : '#E2E8F0' }};">
                        @if($img->is_primary)
                            <span style="position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); background: #0052D1; color: #fff; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 10px; white-space: nowrap;">PRIMARY</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Right: Documents, timeline --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Documents --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
            <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #374151; margin: 0 0 16px 0;">Compliance Documents</h4>
            @forelse($product->documents as $doc)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #F1F5F9;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i data-lucide="file-text" style="width: 16px; height: 16px; color: #0052D1;"></i>
                        <div>
                            <p style="font-size: 13px; font-weight: 500; color: #0F172A; margin: 0;">{{ $doc->title ?? $doc->document_type->name }}</p>
                            <p style="font-size: 11px; color: #94A3B8; margin: 0;">v{{ $doc->version }}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 12px;
                            background: {{ $doc->status->name === 'Accepted' ? '#D1FAE5' : ($doc->status->name === 'Rejected' ? '#FEE2E2' : '#FEF3C7') }};
                            color: {{ $doc->status->name === 'Accepted' ? '#065F46' : ($doc->status->name === 'Rejected' ? '#991B1B' : '#92400E') }};">
                            {{ strtoupper($doc->status->name) }}
                        </span>
                        <a href="{{ route('app.documents.download', $doc->id) }}"
                           style="color: #0052D1; text-decoration: none;">
                            <i data-lucide="download" style="width: 14px; height: 14px;"></i>
                        </a>
                    </div>
                </div>
            @empty
                <p style="font-size: 13px; color: #94A3B8; margin: 0;">No documents uploaded.</p>
            @endforelse
        </div>

        {{-- Submission timeline --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
            <h4 style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #374151; margin: 0 0 16px 0;">Timeline</h4>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                    <span style="color: #64748B;">Created</span>
                    <span style="font-weight: 500; color: #0F172A;">{{ $product->created_at->format('M d, Y H:i') }}</span>
                </div>
                @if($product->submitted_at)
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span style="color: #64748B;">Submitted</span>
                        <span style="font-weight: 500; color: #0F172A;">{{ $product->submitted_at->format('M d, Y H:i') }}</span>
                    </div>
                @endif
                @if($product->reviewed_at)
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span style="color: #64748B;">Reviewed</span>
                        <span style="font-weight: 500; color: #0F172A;">{{ $product->reviewed_at->format('M d, Y H:i') }}</span>
                    </div>
                @endif
                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                    <span style="color: #64748B;">Last Updated</span>
                    <span style="font-weight: 500; color: #0F172A;">{{ $product->updated_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
