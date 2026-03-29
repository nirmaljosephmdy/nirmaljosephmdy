<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $productStats = [
            'draft'       => Product::where('status', ProductStatus::Draft)->count(),
            'in_review'   => Product::where('status', ProductStatus::InReview)->count(),
            'compliant'   => Product::where('status', ProductStatus::Compliant)->count(),
            'incompliant' => Product::where('status', ProductStatus::Incompliant)->count(),
            'rejected'    => Product::where('status', ProductStatus::Rejected)->count(),
        ];

        $manufacturerStats = [
            'total'   => Company::count(),
            'active'  => User::where('role', UserRole::Manufacturer)->where('is_blocked', false)->count(),
            'blocked' => User::where('role', UserRole::Manufacturer)->where('is_blocked', true)->count(),
        ];

        $pendingRegistration = Company::whereHas('user', fn($q) => $q->where('role', UserRole::Manufacturer)
            ->whereNull('email_verified_at')
        )->latest()->first();

        $auditLogs = AdminAuditLog::with('admin')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'productStats',
            'manufacturerStats',
            'pendingRegistration',
            'auditLogs'
        ));
    }
}
