<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
class AuthService { public function login(array $credentials) { if (Auth::attempt($credentials)) { session()->regenerate(); $user = Auth::user(); if ($user->is_blocked) { Auth::logout(); throw new \Exception('Account suspended'); } return $user; } throw new \Exception('Invalid credentials'); } public function logout() { Auth::logout(); session()->invalidate(); session()->regenerateToken(); } }