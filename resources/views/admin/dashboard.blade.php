@extends('layouts.app')

@section('header', 'Admin Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <!-- Product Compliance Overview -->
    <section style="margin-bottom: 32px;">
        <h3 class="section-label">Product Compliance Overview</h3>
        <div class="compliance-overview">
            <div class="stat-card draft">
                <span class="stat-label">Draft</span>
                <div class="stat-value-row">
                    <span class="stat-value">{{ $productStats['draft'] }}</span>
                    <a href="#" class="stat-link">View <i data-lucide="arrow-right"></i></a>
                </div>
            </div>
            <div class="stat-card in-review">
                <span class="stat-label">In Review</span>
                <div class="stat-value-row">
                    <span class="stat-value">{{ $productStats['in_review'] }}</span>
                    <a href="#" class="stat-link">View <i data-lucide="arrow-right"></i></a>
                </div>
            </div>
            <div class="stat-card compliant">
                <span class="stat-label">Compliant</span>
                <div class="stat-value-row">
                    <span class="stat-value">{{ number_format($productStats['compliant']) }}</span>
                    <a href="#" class="stat-link">View <i data-lucide="arrow-right"></i></a>
                </div>
            </div>
            <div class="stat-card incompliant">
                <span class="stat-label">Incompliant</span>
                <div class="stat-value-row">
                    <span class="stat-value">{{ $productStats['incompliant'] }}</span>
                    <a href="#" class="stat-link">View <i data-lucide="arrow-right"></i></a>
                </div>
            </div>
            <div class="stat-card rejected">
                <span class="stat-label">Rejected</span>
                <div class="stat-value-row">
                    <span class="stat-value">{{ $productStats['rejected'] }}</span>
                    <a href="#" class="stat-link">View <i data-lucide="arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Middle Section: Network & Action Items -->
    <div class="middle-grid" style="margin-bottom: 32px;">
        <div class="manufacturer-network-section">
            <h3 class="section-label">Manufacturer Network</h3>
            <div class="manufacturer-network">
                <div class="network-stats">
                    <div class="network-stat-item">
                        <h3>{{ $manufacturerStats['total'] }}</h3>
                        <p>Total Manufacturers</p>
                    </div>
                    <div class="network-stat-item active">
                        <h3>{{ $manufacturerStats['active'] }}</h3>
                        <p>Active Portals</p>
                    </div>
                    <div class="network-stat-item blocked">
                        <h3>{{ $manufacturerStats['blocked'] }}</h3>
                        <p>Blocked Entities</p>
                    </div>
                </div>

                @if($pendingRegistration)
                <div class="registration-request">
                    <div class="request-info">
                        <h5>New Registration Request</h5>
                        <p>{{ $pendingRegistration->name }} is awaiting verification.</p>
                    </div>
                    <button class="btn-review">Review</button>
                </div>
                @endif
            </div>
        </div>

        <div class="action-items-container">
            <h3 class="section-label">Action Items</h3>
            <div class="action-items-section">
                <div class="action-card dark">
                    <div class="action-card-header">
                        <div class="action-icon-box">
                            <i data-lucide="clipboard-check"></i>
                        </div>
                        <span class="priority-badge">Priority High</span>
                    </div>
                    <div class="action-info">
                        <h4>Review Queue</h4>
                        <p>{{ $productStats['in_review'] }} submission{{ $productStats['in_review'] === 1 ? '' : 's' }} pending admin sign-off</p>
                    </div>
                </div>
                <div class="action-card light">
                    <div class="action-card-header">
                        <div class="action-icon-box" style="background: #FEE2E2; color: #EF4444;">
                            <i data-lucide="user-x"></i>
                        </div>
                    </div>
                    <div class="action-info">
                        <h4 style="color: #0F172A;">Blocked Users</h4>
                        <p style="color: #64748B;">{{ $manufacturerStats['blocked'] }} user{{ $manufacturerStats['blocked'] === 1 ? '' : 's' }} flagged for compliance violations</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Audit Log -->
    <section class="audit-log-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 class="section-label" style="margin-bottom: 0;">System Audit Log</h3>
            <a href="#" class="export-link">Full Export <i data-lucide="download"></i></a>
        </div>
        <div class="audit-log-container">
            <table class="audit-table">
                <thead>
                    <tr>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Target</th>
                        <th>Notes</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs as $log)
                    @php
                        $adminName = $log->admin?->name ?? 'System';
                        $initials = collect(explode(' ', $adminName))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('');
                        $actionTag = strtolower(str_replace(' ', '-', $log->action));
                        $target = $log->target_type ? $log->target_type . ': #' . $log->target_id : '—';
                        $time = $log->created_at->isToday()
                            ? $log->created_at->format('g:i A')
                            : ($log->created_at->isYesterday() ? 'Yesterday' : $log->created_at->format('d M Y'));
                    @endphp
                    <tr>
                        <td>
                            <div class="admin-cell">
                                <div class="admin-bubble" style="background: #00183F; color: #FFFFFF;">{{ $initials }}</div>
                                <span>{{ $adminName }}</span>
                            </div>
                        </td>
                        <td><span class="status-tag {{ $actionTag }}">{{ $log->action }}</span></td>
                        <td class="target-cell">{{ $target }}</td>
                        <td>{{ $log->notes ?? '—' }}</td>
                        <td class="time-cell">{{ $time }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748B; padding: 24px;">No audit log entries yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<style>
    /* Inline layout fixes specifically for dashboard elements */
    .dashboard-wrapper {
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection