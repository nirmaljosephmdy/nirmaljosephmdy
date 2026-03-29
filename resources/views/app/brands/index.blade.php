@extends('layouts.app')
@section('title', 'Brands | EUVerify')
@section('header', 'Brands')
@section('content')

<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 700; color: #00183F; margin: 0;">Brands</h2>
            <p style="color: #64748B; margin: 4px 0 0 0; font-size: 14px;">
                Manage your compliance portfolio across different brand entities and monitor their verification status.
            </p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <form method="GET" action="{{ route('app.brands.index') }}" style="display: flex; gap: 8px; align-items: center;">
                <select name="is_active" onchange="this.form.submit()"
                    style="padding: 8px 16px; border: 1px solid #E2E8F0; border-radius: 8px; background: #fff; color: #374151; font-size: 14px; cursor: pointer;">
                    <option value="">All Brands</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </form>
            <a href="{{ route('app.brands.create') }}"
               style="display: flex; align-items: center; gap: 8px; background: #00183F; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Create Brand
            </a>
        </div>
    </div>
</div>

{{-- Stats Row --}}
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px;">
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">TOTAL BRANDS</p>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 36px; font-weight: 700; color: #00183F;">{{ $stats['total'] }}</span>
            <span style="font-size: 13px; color: #10B981; font-weight: 500;">+{{ $brands->where('created_at', '>=', now()->startOfMonth())->count() }} this month</span>
        </div>
    </div>
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">ACTIVE COMPLIANCE</p>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            @php
                $pct = $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100) : 0;
            @endphp
            <span style="font-size: 36px; font-weight: 700; color: #00183F;">{{ $pct }}%</span>
            <i data-lucide="trending-up" style="width: 18px; height: 18px; color: #10B981;"></i>
        </div>
    </div>
    <div style="background: #fff; border-radius: 12px; padding: 24px; border: 1px solid #E2E8F0;">
        <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B; margin: 0 0 8px 0;">INACTIVE BRANDS</p>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 36px; font-weight: 700; color: #00183F;">{{ str_pad($stats['inactive'], 2, '0', STR_PAD_LEFT) }}</span>
            @if($stats['inactive'] > 0)
                <span style="background: #FEF3C7; color: #D97706; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px;">Needs attention</span>
            @endif
        </div>
    </div>
</div>

{{-- Brand Table --}}
<div style="background: #fff; border-radius: 12px; border: 1px solid #E2E8F0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid #E2E8F0; background: #F8FAFC;">
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">LOGO</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">BRAND NAME</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">WEBSITE</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">STATUS</th>
                <th style="padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">CREATED DATE</th>
                <th style="padding: 12px 20px; text-align: right; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #64748B;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $brand)
            <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='#fff'">
                <td style="padding: 16px 20px;">
                    @if($brand->logo_path)
                        <img src="{{ asset('storage/' . $brand->logo_path) }}" alt="{{ $brand->name }}"
                             style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; border: 1px solid #E2E8F0;">
                    @else
                        <div style="width: 40px; height: 40px; background: #1E293B; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px;">
                            {{ substr($brand->name, 0, 1) }}
                        </div>
                    @endif
                </td>
                <td style="padding: 16px 20px;">
                    <div style="font-weight: 600; color: #0F172A; font-size: 14px;">{{ $brand->name }}</div>
                    <div style="color: #94A3B8; font-size: 12px; margin-top: 2px;">ID: EU-{{ str_pad($brand->id, 4, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($brand->name, 0, 2)) }}</div>
                </td>
                <td style="padding: 16px 20px;">
                    @if($brand->website)
                        <a href="{{ $brand->website }}" target="_blank" rel="noopener"
                           style="color: #0052D1; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                            {{ parse_url($brand->website, PHP_URL_HOST) ?? $brand->website }}
                            <i data-lucide="external-link" style="width: 12px; height: 12px;"></i>
                        </a>
                    @else
                        <span style="color: #CBD5E1; font-size: 14px;">—</span>
                    @endif
                </td>
                <td style="padding: 16px 20px;">
                    @if($brand->is_active)
                        <span style="background: #D1FAE5; color: #065F46; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em;">ACTIVE</span>
                    @else
                        <span style="background: #FEE2E2; color: #991B1B; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.05em;">INACTIVE</span>
                    @endif
                </td>
                <td style="padding: 16px 20px; color: #64748B; font-size: 14px;">
                    {{ $brand->created_at->format('M d, Y') }}
                </td>
                <td style="padding: 16px 20px; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <a href="{{ route('app.brands.edit', $brand->id) }}"
                           style="display: inline-flex; align-items: center; gap: 4px; background: #F1F5F9; color: #374151; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 500;">
                            <i data-lucide="pencil" style="width: 13px; height: 13px;"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('app.brands.destroy', $brand->id) }}"
                              onsubmit="return confirm('Deactivate this brand?')" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                style="display: inline-flex; align-items: center; gap: 4px; background: #FEF2F2; color: #DC2626; padding: 6px 12px; border-radius: 6px; border: none; font-size: 13px; font-weight: 500; cursor: pointer;">
                                <i data-lucide="power-off" style="width: 13px; height: 13px;"></i> Deactivate
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 48px; text-align: center; color: #94A3B8;">
                    <i data-lucide="award" style="width: 40px; height: 40px; margin-bottom: 12px; opacity: 0.4;"></i>
                    <p style="margin: 0; font-size: 14px;">No brands found. <a href="{{ route('app.brands.create') }}" style="color: #0052D1; font-weight: 600;">Create your first brand</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 14px 20px; border-top: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: #64748B; font-weight: 500;">SHOWING {{ $brands->count() }} OF {{ $stats['total'] }} BRANDS</span>
    </div>
</div>

{{-- Certified Compliance Engine Footer --}}
<div style="margin-top: 24px; text-align: right;">
    <div style="display: inline-flex; align-items: center; gap: 8px; color: #64748B;">
        <i data-lucide="shield-check" style="width: 16px; height: 16px; color: #0052D1;"></i>
        <strong style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #00183F;">CERTIFIED COMPLIANCE ENGINE</strong>
    </div>
    <p style="font-size: 12px; color: #94A3B8; margin: 4px 0 0 0;">
        All brand entities listed here are monitored in real-time.<br>
        Changes to status may require up to 24 hours for global registry synchronisation.
    </p>
</div>

@endsection
