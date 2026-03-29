<?php
namespace App\Http\Controllers\Manufacturer;
use App\Http\Controllers\Controller;
class NotificationController extends Controller {
 public function index() { $notifications = auth()->user()->notifications; auth()->user()->unreadNotifications->markAsRead(); return view('app.notifications.index', compact('notifications')); }
}