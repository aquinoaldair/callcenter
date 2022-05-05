<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScriptController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return redirect()->route('dashboard'); //Inertia::render('Welcome');
});


Route::prefix('admin')->middleware('auth')->group(function (){
    Route::get('dashboard', [DashBoardController::class, "index"])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('script', ScriptController::class);
    //Route::resource('image', ImageController::class);
    Route::post('file', [FileController::class, 'store'])->name('file.store');
    Route::post('file/delete', [FileController::class, 'delete'])->name('file.delete');

    Route::prefix('{script_id}')->group(function (){
        Route::get('question/all', [QuestionController::class, 'getByScript'])->name('question.script');
        Route::resource('question', QuestionController::class);
    });
});

