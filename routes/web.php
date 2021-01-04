<?php

use App\Http\Controllers\Backend\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Backend\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\Backend\Auth\ResetPasswordController as AuthResetPasswordController;
use App\Http\Controllers\Backend\Auth\VerificationController as AuthVerificationController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\VerificationController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
// Authentication Routes...
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('show_login_form');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('show_register_form');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['prefix'=>'admin','as'=>'admin.'],function(){
    Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('show_login_form');
    Route::post('login', [AuthLoginController::class, 'login'])->name('login');
    Route::post('logout', [AuthLoginController::class, 'logout'])->name('logout');
    // Route::get('register', [AuthRegisterController::class, 'showRegistrationForm'])->name('show_register_form');
    // Route::post('register', [AuthRegisterController::class, 'register'])->name('register');
    Route::get('password/reset', [AuthForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('email/verify', [AuthVerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [AuthVerificationController::class, 'resend'])->name('verification.resend');
});



Route::get('/home', [HomeController::class, 'index'])->name('home');
