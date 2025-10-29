<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SessionAuthenticate;

// Route::get('/', function () {
//     return view('welcome');
// });

// user All routes

Route::get('/', [HomeController::class, 'index'])->name('home.page');
Route::get('/home', [HomeController::class, 'HomePage'])->name('home');

Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('userRegistration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');
Route::get('/user-logout', [UserController::class, 'UserLogout'])->name('user.logout');

// send otp
Route::post('/send-otp', [UserController::class, 'SendOtpCode'])->name('send.otp');
Route::post('/verify-otp', [UserController::class, 'VerifyOtp'])->name('verify.otp');
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([SessionAuthenticate::class]);

Route::get('/dashboardPage', [UserController::class, 'DashboardPage'])->middleware([SessionAuthenticate::class])->name('dashboard.page');


// Front end All routes
Route::get('/login', [UserController::class, 'LoginPage'])->name('LoginPage');
Route::get('/registration', [UserController::class, 'RegistrationPage'])->name('RegistrationPage');
Route::get('/send-otp', [UserController::class, 'SendOtpPage'])->name('SendOtpPage');
Route::get('/verify-otp', [UserController::class, 'VerifyOtpPage'])->name('VerifyOtpPage');
Route::get('/reset-password', [UserController::class, 'ResetPasswordPage'])->name('ResetPasswordPage')->middleware([SessionAuthenticate::class]);
