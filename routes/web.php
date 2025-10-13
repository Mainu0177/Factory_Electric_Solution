<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// user All routes
Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('userRegistration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');
Route::get('/user-logout', [UserController::class, 'UserLogout'])->name('user.logout');



// Front end All routes
Route::get('/login', [UserController::class, 'LoginPage'])->name('LoginPage');
