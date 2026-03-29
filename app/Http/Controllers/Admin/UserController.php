<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogService;
use App\Support\ApiResponse;
class UserController extends Controller {
 public function index() { return view('admin.users.index', ['users' => User::where('role', \App\Enums\UserRole::Manufacturer)->get()]); }
 public function block($user, AuditLogService $logger) { $u = User::findOrFail($user); $u->is_blocked = true; $u->save(); $logger->log(auth()->id(), 'Blocked User', 'User', $u->id); return request()->expectsJson() ? ApiResponse::success(null) : redirect()->back(); }
 public function unblock($user, AuditLogService $logger) { $u = User::findOrFail($user); $u->is_blocked = false; $u->save(); $logger->log(auth()->id(), 'Unblocked User', 'User', $u->id); return request()->expectsJson() ? ApiResponse::success(null) : redirect()->back(); }
 public function subscriptionOverride($user, \Illuminate\Http\Request $request, AuditLogService $logger) { $request->validate(['status' => 'required|integer']); $u = User::findOrFail($user); if ($u->subscription) { $u->subscription->status = $request->status; $u->subscription->save(); $logger->log(auth()->id(), 'Overrode Subscription', 'Subscription', $u->subscription->id); } return request()->expectsJson() ? ApiResponse::success(null) : redirect()->back(); }
}