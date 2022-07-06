<?php

use App\Http\Controllers\Teachers\TeachersController;
use Illuminate\Support\Facades\Route;



Route::get('list-all',[TeachersController::class,'index'])->name('fetch.all');
Route::post('store-staff',[TeachersController::class,'store'])->name('add.staff');
Route::get('datatable',[TeachersController::class,'datatable'])->name('staff.datatable');
Route::get('staff-form',[TeachersController::class,'getstaff'])->name('staff.form');
Route::get('teacheredit/{id}',[TeachersController::class,'edit']);

?>