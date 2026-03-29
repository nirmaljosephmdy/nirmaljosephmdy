@extends('layouts.app')
@section('title', 'Product Details | EUVerify')
@section('header', 'New Product')
@section('content')

<div style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B;">
    <span style="font-weight: 600; color: #0052D1;">NEW PRODUCT</span>
    <span>/</span>
    <span>CREATION WIZARD</span>
    <span style="margin-left: auto; display: flex; align-items: center; gap: 6px; color: #10B981; font-size: 13px; font-weight: 500;">
        <i data-lucide="cloud" style="width: 14px; height: 14px;"></i> AUTO-SAVED
    </span>
</div>

@include('app.products.create._wizard-header')

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 40px;">
        <h3 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0 0 8px 0;">Technical Specifications</h3>
        <p style="color: #64748B; font-size: 14px; margin: 0 0 32px 0;">
            Provide detailed product information for the digital notary registry. Ensure SKU and Batch numbers match your internal ERP systems.
        </p>

        @if($errors->any())
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px;">
                @foreach($errors->all() as $err)
                    <p style="color: #DC2626; font-size: 13px; margin: 0;">{{ $err }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('app.products.step2.save', $product->id) }}">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">PRODUCT NAME *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       placeholder="e.g. Hyper-Efficiency Cooling Unit X-9"
                       style="width: 100%; padding: 12px 16px; border: 1px solid {{ $errors->has('name') ? '#DC2626' : '#E2E8F0' }}; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; box-sizing: border-box;">
                @error('name') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">FULL DESCRIPTION * <span style="color: #94A3B8; font-weight: 400;">(min 50 chars)</span></label>
                <textarea name="description" rows="5" id="desc-field"
                          placeholder="Detailed product specifications, materials, and compliance context..."
                          style="width: 100%; padding: 12px 16px; border: 1px solid {{ $errors->has('description') ? '#DC2626' : '#E2E8F0' }}; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; resize: vertical; box-sizing: border-box; font-family: inherit;">{{ old('description', $product->description) }}</textarea>
                @error('description') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">SKU NUMBER</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                           placeholder="SKU-000-000"
                           style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">BATCH ID / LOT</label>
                    <input type="text" name="batch_number" value="{{ old('batch_number', $product->batch_number) }}"
                           placeholder="B-2024-V1"
                           style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">INTENDED USE CASE *</label>
                <input type="text" name="intended_use" value="{{ old('intended_use', $product->intended_use) }}"
                       placeholder="Industrial HVAC, server room temperature management"
                       style="width: 100%; padding: 12px 16px; border: 1px solid {{ $errors->has('intended_use') ? '#DC2626' : '#E2E8F0' }}; border-radius: 8px; font-size: 14px; color: #0F172A; outline: none; box-sizing: border-box;">
                @error('intended_use') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 40px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">REGISTERED BRAND <span style="color: #94A3B8; font-weight: 400;">(optional)</span></label>
                <div style="position: relative;">
                    <select name="brand_id"
                        style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; background: #fff; outline: none; appearance: none; padding-right: 40px; box-sizing: border-box;">
                        <option value="">Select a verified brand...</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="chevron-down" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94A3B8; pointer-events: none;"></i>
                </div>
                @error('brand_id') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; justify-content: space-between;">
                <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 1]) }}"
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Back to Classification
                </a>
                <button type="submit"
                    style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 12px 28px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                    Save &amp; Continue <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Right info panel --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                <i data-lucide="lightbulb" style="width: 18px; height: 18px; color: #F59E0B;"></i>
                <h4 style="font-size: 14px; font-weight: 700; color: #00183F; margin: 0;">Why these details matter</h4>
            </div>
            <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">
                Product details are cryptographically hashed and stored as part of your EU Compliance Ledger. Ensuring accuracy now prevents delays during the Audit Review stage.
            </p>
        </div>

        <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 20px;">
            <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                <input type="checkbox" id="accuracy-confirm" style="margin-top: 2px; width: 16px; height: 16px; accent-color: #0052D1;">
                <span style="font-size: 13px; color: #374151; line-height: 1.5;">
                    I confirm that the product specifications provided are accurate and match the manufacturing documentation.
                </span>
            </label>
        </div>
    </div>
</div>

@endsection
