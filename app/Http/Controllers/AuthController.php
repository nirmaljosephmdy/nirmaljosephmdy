<?php
namespace App\Http\Controllers;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
class AuthController extends Controller {
 public function showLogin() { return view('auth.login'); }
 public function login(LoginRequest $request, AuthService $service) {
 try { $user = $service->login($request->validated()); $redirect = $user->role === \App\Enums\UserRole::Admin ? '/admin/dashboard' : '/app/dashboard'; return $request->expectsJson() ? ApiResponse::success(['redirect' => $redirect]) : redirect($redirect); } catch (\Exception $e) { return $request->expectsJson() ? ApiResponse::error($e->getMessage()) : back()->withErrors(['email' => $e->getMessage()]); }
 }
 public function logout(Request $request, AuthService $service) { $service->logout(); return $request->expectsJson() ? ApiResponse::success(null, 'Logged out') : redirect('/'); }
}