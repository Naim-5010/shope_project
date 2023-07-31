<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVirficationMiddleware;




// 👑👑 Page Route
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verityOtp', [UserController::class, 'VerifyOtpPage']);
Route::get('/resetPass', [UserController::class, 'ResetPassPage']);
Route::get('/dashboard', [UserController::class, 'DashboardPage']);



// 👑👑 API Route

Route::post('/User-Registration', [UserController::class, 'UserRegistration']);
Route::post('/User-Login', [UserController::class, 'UserLogin']);
Route::post('/OTP-Send', [UserController::class, 'SendOTP']);
Route::post('/Verify-OTP', [UserController::class, 'VerifyOTP']);

// Token Verify korte hobe
Route::post('/Reset-password', [UserController::class, 'ResetPass'])->middleware([TokenVirficationMiddleware::class]);


//👑👑  User LogOut
Route::get('/logOut', [UserController::class, "UserLogOut"]);
