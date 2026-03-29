@extends('layouts.app')
@section('title', 'AR Address | EUVerify')
@section('header', 'New Product')
@section('content')

<div style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748B;">
    <span style="font-weight: 600; color: #0052D1;">NEW PRODUCT</span>
    <span>/</span>
    <span>CREATION WIZARD</span>
</div>

@include('app.products.create._wizard-header')

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 40px;">
        <h3 style="font-size: 26px; font-weight: 700; color: #00183F; margin: 0 0 8px 0;">Authorised Representative</h3>
        <p style="color: #64748B; font-size: 14px; margin: 0 0 32px 0;">
            Assign EU and optionally UK Authorised Representatives for this product.
        </p>

        @if($errors->any())
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px;">
                @foreach($errors->all() as $err)
                    <p style="color: #DC2626; font-size: 13px; margin: 0;">{{ $err }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('app.products.step4.save', $product->id) }}">
            @csrf

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">
                    EU AUTHORISED REPRESENTATIVE *
                    <span style="background: #DBEAFE; color: #1E40AF; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">REQUIRED</span>
                </label>
                <select name="ar_eu_id" required
                    style="width: 100%; padding: 12px 16px; border: 1px solid {{ $errors->has('ar_eu_id') ? '#DC2626' : '#E2E8F0' }}; border-radius: 8px; font-size: 14px; color: #0F172A; background: #fff; outline: none; appearance: none; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px;">
                    <option value="">Select EU AR address...</option>
                    @foreach($eu_addresses as $ar)
                        <option value="{{ $ar->id }}" {{ old('ar_eu_id', $product->ar_eu_id) == $ar->id ? 'selected' : '' }}>
                            {{ $ar->name }} — {{ $ar->city }}, {{ $ar->country }}
                        </option>
                    @endforeach
                </select>
                @error('ar_eu_id') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 40px;">
                <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin-bottom: 8px;">
                    UK AUTHORISED REPRESENTATIVE
                    <span style="background: #F1F5F9; color: #64748B; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">OPTIONAL</span>
                </label>
                @if($uk_addresses->isEmpty())
                    <div style="padding: 14px 16px; background: #FEF9C3; border: 1px solid #FDE68A; border-radius: 8px; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="lock" style="width: 16px; height: 16px; color: #D97706;"></i>
                        <span style="font-size: 13px; color: #92400E;">UK AR address selection requires a higher subscription plan.</span>
                    </div>
                @else
                    <select name="ar_uk_id"
                        style="width: 100%; padding: 12px 16px; border: 1px solid #E2E8F0; border-radius: 8px; font-size: 14px; color: #0F172A; background: #fff; outline: none; appearance: none; background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px;">
                        <option value="">None selected</option>
                        @foreach($uk_addresses as $ar)
                            <option value="{{ $ar->id }}" {{ old('ar_uk_id', $product->ar_uk_id) == $ar->id ? 'selected' : '' }}>
                                {{ $ar->name }} — {{ $ar->city }}, {{ $ar->country }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('ar_uk_id') <p style="color: #DC2626; font-size: 13px; margin: 6px 0 0 0;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; justify-content: space-between;">
                <a href="{{ route('app.products.step', ['product' => $product->id, 'step' => 3]) }}"
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; border: 1px solid #E2E8F0; border-radius: 8px; color: #374151; text-decoration: none; font-weight: 600; font-size: 14px; background: #fff;">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Back
                </a>
                <button type="submit"
                    style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 12px 28px; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                    Save &amp; Continue <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                </button>
            </div>
        </form>
    </div>

    <div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; padding: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
            <i data-lucide="map-pin" style="width: 18px; height: 18px; color: #0052D1;"></i>
            <h4 style="font-size: 14px; font-weight: 700; color: #00183F; margin: 0;">AR Address Info</h4>
        </div>
        <p style="font-size: 13px; color: #64748B; line-height: 1.6; margin: 0;">
            An Authorised Representative (AR) is required for all products placed on the EU market by non-EU manufacturers. The UK AR is required for UKCA marking.
        </p>
    </div>
</div>

@endsection
