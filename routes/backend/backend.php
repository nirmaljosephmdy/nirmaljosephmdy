<?php

use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\Questions\QuestionsController;
use App\Http\Controllers\Teachers\TeachersController;
use Illuminate\Support\Facades\Route;
use MongoDB\Operation\Update;


Route::middleware('auth:admin')->prefix('teacher')->name('teacher.')->group(function (){


    Route::get('home',[TeachersController::class,'home'])->name('home');
    Route::get('/index',[TeachersController::class,'index'])->name('index');
    Route::get('datatable',[TeachersController::class,'datatable'])->name('datatable');
    Route::get('create',[TeachersController::class,'getstaff'])->name('create');
    Route::post('/store',[TeachersController::class,'store'])->name('store');
    Route::get('{teacher}/edit',[TeachersController::class,'edit'])->name('edit');
    Route::post('update-teacher',[TeachersController::class,'update'])->name('update');
    Route::get('remove/{remove}',[TeachersController::class,'destroy'])->name('remove');

});



Route::middleware('auth:admin')->prefix('questions')->name('question.')->group(function (){


    Route::get('show',[QuestionsController::class,'show'])->name('show');
    Route::get('datatable',[QuestionsController::class,'datatable'])->name('datatable');
    Route::get('add',[QuestionsController::class,'index'])->name('add');
    Route::post('store',[QuestionsController::class,'store'])->name('store');
    Route::get('{question_id}/edit',[QuestionsController::class,'edit'])->name('edit');
    Route::post('update',[QuestionsController::class,'update'])->name('update');
    Route::get('remove/{remove_id}',[QuestionsController::class,'destroy'])->name('remove');

});



Route::middleware('auth:admin')->prefix('exam')->name('exam.')->group(function(){


    Route::get('add',[ExamController::class,'index'])->name('add');








});

?>