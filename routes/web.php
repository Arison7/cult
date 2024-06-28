<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ErrorController;


Auth::routes(['verify' => true]);
Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
Route::post('/register', [RegisterController::class, 'store'])->name('auth.register');
Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');
Route::post('/login', [LoginController::class, 'store'])->name('auth.login');
Route::get('/login', [LoginController::class, 'index'])->name('auth.login');
Route::redirect('/laravel/login', '/login')->name('login');
Route::redirect('/laravel/logout', '/logout')->name('logout');
Route::post('/logout', [LogoutController::class, 'store'])->name('auth.logout');
Route::get('/register/uniqueName', [UserController::class, 'uniqueUsername'])->name('auth.checkName');
Route::get('/errors/notFound', [ErrorController::class, 'notFound'])->name('errors.notFound');
Route::get('/errors/internalSeverError', [ErrorController::class, 'internalServerError'])->name('errors.internalServerError');
