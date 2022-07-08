<?php

use App\Http\Controllers\Teachers\TeachersController;
use App\Http\Controllers\Usermanagement\LoginController;
use Illuminate\Support\Facades\Route;


Route::post('login',[LoginController::class,'index'])->name('login');

Route::get('register',[LoginController::class,'register'])->name('register');

Route::get('logout',[LoginController::class,'logout'])->name('login.logout');

;































?>
