@extends('layouts.app')

@section('title', 'AR Address Management')

@section('content')
<div class="ar-page-content" x-data="{ showDeleteModal: false, deleteUrl: '' }">
    
    <!-- Header -->
    <div class="ar-page-header">
        <div>
            <h1>AR Address Management</h1>
            <p>Configure and manage Authorized Representative locations across global jurisdictions.</p>
        </div>
        <a href="{{ route('admin.ar-addresses.create') }}" class="btn-primary">
            <i data-lucide="plus" style="width: 16px;"></i> Add Entry
        </a>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form action="{{ route('admin.ar-addresses.index') }}" method="GET" class="filter-group">
            <!-- Region Filter -->
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="filter-label">Region</span>
                <select name="region" class="modern-select" onchange="this.form.submit()">
                    <option value="">All Regions</option>
                    <option value="1" {{ request('region') == '1' ? 'selected' : '' }}>EU</option>
                    <option value="2" {{ request('region') == '2' ? 'selected' : '' }}>UK</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="filter-label">Status</span>
                <select name="status" class="modern-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Hidden search to keep state -->
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
        </form>

        <div class="display-info">
            <span>Displaying {{ $arAddresses->firstItem() ?? 0 }} to {{ $arAddresses->lastItem() ?? 0 }} of {{ $arAddresses->total() }} addresses</span>
            <button class="icon-btn">
                <i data-lucide="sliders-horizontal" style="width: 18px;"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="ar-table-box">
        <table class="ar-table">
            <thead>
                <tr>
                    <th style="width: 8%">ID</th>
                    <th style="width: 25%">Representative Name</th>
                    <th style="width: 10%; text-align: center;">Region</th>
                    <th style="width: 20%">Location</th>
                    <th style="width: 20%">Contact Email</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 7%; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arAddresses as $ar)
                    <tr>
                        <td class="ar-id">#AR-{{ str_pad($ar->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="ar-name">{{ $ar->name }}</div>
                            <div class="ar-sub">Main Branch</div>
                        </td>
                        <td style="text-align: center;">
                            @if($ar->region->value == 1)
                                <span class="badge-region eu">EU</span>
                            @else
                                <span class="badge-region uk">UK</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $ar->city }}, {{ $ar->postcode }}</div>
                            <div style="font-size: 11px; color: #64748B;">{{ $ar->country }}</div>
                        </td>
                        <td>
                            <a href="mailto:{{ $ar->contact_email }}" class="text-email">{{ $ar->contact_email }}</a>
                        </td>
                        <td>
                            @if($ar->is_active)
                                <span class="badge-status active">ACTIVE</span>
                            @else
                                <span class="badge-status inactive">INACTIVE</span>
                            @endif
                        </td>
                        <td>
                            <div class="ar-actions" style="justify-content: flex-end;">
                                <a href="{{ route('admin.ar-addresses.edit', $ar->id) }}" title="Edit">
                                    <i data-lucide="edit-3" style="width: 18px;"></i>
                                </a>
                                <button type="button" @click="showDeleteModal = true; deleteUrl = '{{ route('admin.ar-addresses.destroy', $ar->id) }}'" title="Delete">
                                    <i data-lucide="trash-2" style="width: 18px;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 48px; color: #64748B;">
                            No Authorized Representatives found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination Area -->
        @if($arAddresses->hasPages())
        <div style="padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #F1F5F9;">
            <div style="font-size: 12px; color: #64748B;">
                Rows per page: <strong>25</strong>
            </div>
            <div>
                {{ $arAddresses->links('pagination::simple-tailwind') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Dash Cards -->
    <div class="ar-dash-grid">
        <!-- Distribution Card -->
        <div class="ar-dash-card">
            <div class="card-top-left">
                <div class="ar-dash-icon"><i data-lucide="globe" style="width: 20px;"></i></div>
                <div class="ar-dash-label">Region Distribution</div>
            </div>
            <div class="ar-dash-val eu-accent">
                <h2>{{ $stats['eu_percentage'] }}% EU</h2>
                <p>Major cluster in Central Europe</p>
            </div>
            <i data-lucide="globe-2" class="bg-watermark"></i>
        </div>

        <!-- Health Card -->
        <div class="ar-dash-card">
            <div class="card-top-left">
                <div class="ar-dash-icon"><i data-lucide="check-square" style="width: 20px;"></i></div>
                <div class="ar-dash-label">Address Health</div>
            </div>
            <div class="ar-dash-val eu-accent">
                <h2>{{ $stats['valid_count'] }} Valid</h2>
                <p>{{ $arAddresses->total() > 0 ? round(($stats['valid_count'] / $arAddresses->total()) * 100, 1) : 0 }}% Current validity rate</p>
            </div>
            <i data-lucide="shield-check" class="bg-watermark"></i>
        </div>

        <!-- Activity Card -->
        <div class="ar-dash-card dark">
            <div class="card-top-left">
                <div class="ar-dash-icon"><i data-lucide="history" style="width: 20px;"></i></div>
                <div class="ar-dash-label" style="color: #94A3B8;">Recent Activity</div>
            </div>
            <div class="ar-dash-val">
                <h2>{{ $stats['recent_updates'] }} Updates</h2>
                <p>Modified in the last 24 hours</p>
            </div>
            <i data-lucide="clock-4" class="bg-watermark"></i>
        </div>
    </div>

    <!-- Delete Modal (Alpine.js) -->
    <div x-show="showDeleteModal" style="display: none;" class="modal-overlay">
        <div class="modal-content" @click.away="showDeleteModal = false">
            <div class="modal-icon">
                <i data-lucide="alert-triangle" style="width: 32px; height: 32px;"></i>
            </div>
            <h3>Delete AR Address</h3>
            <p>Are you sure you want to delete this Authorized Representative? This action cannot be undone and may affect associated products.</p>
            
            <form x-bind:action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" @click="showDeleteModal = false">Cancel</button>
                    <button type="submit" class="btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection