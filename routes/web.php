<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/principal', function () {
    return view('principal');
})->middleware('auth');

Route::get('/registro', [RegisterController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [RegisterController::class, 'registrar']);

Route::get('/forgot-password', [PasswordResetController::class, 'mostrarFormulario'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'enviarEnlace'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'mostrarReset'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetear'])->name('password.update');