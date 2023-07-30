<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerifyMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login-page', [UserController::class, 'LoginPage']);
Route::get('/registration-page', [UserController::class, 'RegistrationPage']);
Route::get('/reset-pass-page', [UserController::class, 'ResetPasswordPage']);
Route::get('/send-otp-page', [UserController::class, 'SendOTPPage']);
Route::get('/verify-otp-page', [UserController::class, 'VerifyOTPPage']);
Route::get('/userProfile', [UserController::class, 'ProfilePage']);
Route::get('/dashboard', [UserController::class, 'Dashboard']);


Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTP']);
Route::post('/otp-verify', [UserController::class, 'VerifyOTP']);
Route::post('/pass-reset', [UserController::class, 'PasswordReset'])->middleware(TokenVerifyMiddleware::class);
