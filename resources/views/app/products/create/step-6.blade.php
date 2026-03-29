@extends('layouts.app')
@section('title', 'Review & Submit | EUVerify')
@section('header', 'New Product')
@section('content')

@php
$ready = $product->name && $product->description && $product->intended_use
      && $product->category_id && $product->product_category_id
      && $product->ar_eu_id
      && $product->images->isNotEmpty()
      && $product->documents->isNotEmpty();
@endphp

<div style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B;">
    <span style="font-weight: 600; color: #0052D1;">NEW PRODUCT</span>
    <span>/</span>
    <span>CREATION WIZARD</span>
</div>

@include('app.products.create._wizard-header')

@if($errors->any())
    <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
        @foreach($errors->all() as $err)
            <p style="color: #DC2626; font-size: 13px; margin: 0;">{{ $err }}</p>
        @endforeach
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 40px;">
        <h3 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0 0 8px 0;">Review &amp; Submit</h3>
        <p style="color: #64748B; font-size: 14px; margin: 0 0 32px 0;">
            Review your product details before submitting for compliance review.
        </p>

        {{-- Checklist --}}
        @php
        $checks = [
            'Category set'          => (bool) $product->category_id,
            'Sub-category set'      => (bool) $product->product_category_id,
            'Product name'          => (bool) $product->name,
            'Description (50+ chars)' => strlen($product->description ?? '') >= 50,
            'Intended use'          => (bool) $product->intended_use,
            'EU AR address'         => (bool) $product->ar_eu_id,
            'At least 1 image'      => $product->images->isNotEmpty(),
            'At least 1 document'   => $product->documents->isNotEmpty(),
        ];
        @endphp

        <div style="margin-bottom: 32px;">
            <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #374151; margin: 0 0 12px 0;">SUBMISSION CHECKLIST</p>
            @foreach($checks as $label => $passed)
                <div style="display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #F1F5F9;">
                    @if($passed)
                        <div style="width: 20px; height: 20px; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-lucide="check" style="width: 12px; height: 12px; color: #065F46;"></i>
                        </div>
                        <span style="font-size: 13px; color: #374151;">{{ $label }}</span>
                    @else
                        <div style="width: 20px; height: 20px; background: #FEE2E2; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-lucide="x" style="width: 12px; height: 12px; color: #DC2626;"></i>
                        </div>
                        <span style="font-size: 13px; color: #DC2626; font-weight: 500;">{{ $label }} — incomplete</span>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Product Summary --}}
        <div style="background: #F8FAFC; border-radius: 10px; padding: 20px; margin-bottom: 32px;">
            <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #374151; margin: 0 0 12px 0;">PRODUCT SUMMARY</p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">PRODUCT NAME</p>
                    <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $product->name ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">CATEGORY</p>
                    <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $product->category?->name ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">SKU</p>
                    <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $product->sku ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">IMAGES</p>
                    <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $product->images->count() }} uploaded</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">DOCUMENTS</p>
                    <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $product->documents->count() }} uploaded</p>
                </div>
                <div>
                    <p style="font-size: 11px; color: #94A3B8; margin: 0 0 2px 0;">EU AR</p>
                    <p style="font-size: 13px; font-weight: 600; color: #0F172A; margin: 0;">{{ $product->arEu?->name ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between;">
            <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 5]) }}"
               style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Back
            </a>

            @if($ready)
                <form method="POST" action="{{ route('app.products.submit', $product->id) }}">
                    @csrf
                    <button type="submit"
                        style="display: flex; align-items: center; gap: 8px; background: #10B981; color: #fff; padding: 12px 28px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i data-lucide="send" style="width: 16px; height: 16px;"></i> Submit for Review
                    </button>
                </form>
            @else
                <button disabled
                    style="display: flex; align-items: center; gap: 8px; background: #E2E8F0; color: #94A3B8; padding: 12px 28px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: not-allowed;">
                    <i data-lucide="send" style="width: 16px; height: 16px;"></i> Complete Required Fields First
                </button>
            @endif
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="background: {{ $ready ? '#D1FAE5' : '#FEF3C7' }}; border-radius: 12px; border: 1px solid {{ $ready ? '#6EE7B7' : '#FDE68A' }}; padding: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <i data-lucide="{{ $ready ? 'check-circle' : 'alert-triangle' }}" style="width: 18px; height: 18px; color: {{ $ready ? '#065F46' : '#D97706' }};"></i>
                <h4 style="font-size: 14px; font-weight: 700; color: {{ $ready ? '#065F46' : '#92400E' }}; margin: 0;">
                    {{ $ready ? 'Ready to Submit' : 'Incomplete Product' }}
                </h4>
            </div>
            <p style="font-size: 13px; color: {{ $ready ? '#065F46' : '#92400E' }}; margin: 0; line-height: 1.6;">
                @if($ready)
                    All required fields are complete. Once submitted, the product will enter the compliance review queue.
                @else
                    Please complete all required fields in the checklist before submitting.
                @endif
            </p>
        </div>

        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <i data-lucide="info" style="width: 16px; height: 16px; color: #0052D1;"></i>
                <h4 style="font-size: 13px; font-weight: 700; color: #0F172A; margin: 0;">After Submission</h4>
            </div>
            <p style="font-size: 13px; color: #64748B; margin: 0; line-height: 1.6;">
                Your product will be placed in the compliance review queue. You cannot edit it while it's under review. You'll receive a notification once the review is complete.
            </p>
        </div>
    </div>
</div>

@endsection
