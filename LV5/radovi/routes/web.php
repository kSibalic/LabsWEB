<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/locale/{locale}', [LocaleController::class, 'setLocale'])->name('locale.set');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::post('/tasks/{task}/apply', [TaskController::class, 'apply'])->name('tasks.apply');
    Route::post('/tasks/{task}/accept/{student}', [TaskController::class, 'acceptStudent'])->name('tasks.accept');
});
