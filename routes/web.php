<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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
// Web API Routes
Route::post('/user-register', [UserController::class, 'UserRegister']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTP']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
//token verify issue arise here so we need to add middleware
Route::post('/reset-pass', [UserController::class,'ResetPassword'])
->middleware([TokenVerificationMiddleware::class]);



//View page routs
Route::get('/user_login',[UserController::class,'LoginPage'])->name('login');
Route::get('/user_register',[UserController::class,'RegisterPage'])->name('register');
Route::get('/send_otp',[UserController::class,'ThrowOTP'])->name('send_otp');
Route::get('/verify_otp',[UserController::class,'ConfirmOTP'])->name('verify_otp');
Route::get('/reset_password',[UserController::class,'PassresetPage'])->name('password_reset');
Route::get('/dashboard',[UserController::class,'Dashboard'])->middleware([TokenVerificationMiddleware::class])->name('dashboard');
Route::get('/profile',[UserController::class,'ProfileView'])->name('profile');