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
use App\Http\Controllers\Frontend\UserController;
use App\Http\Frontend\Controllers\IndexController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

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



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact-us',[HomeController::class,'contact_us'])->name('contact');
Route::post('/contact-us',[HomeController::class,'store_contact_us'])->name('store.contact');
Route::get('/{page_slug}',[HomeController::class,'show_page'])->name('pages.show');
Route::get('/post/{post}',[HomeController::class,'show_post'])->name('posts.show');
Route::post('/{post:slug}',[HomeController::class,'store_comment'])->name('add.comment');
Route::get('/posts/search',[HomeController::class,'search'])->name('posts.search');
Route::get('/category/{category:slug}',[HomeController::class,'category'])->name('category.posts');
Route::get('/archive/{date}',[HomeController::class,'archive'])->name('archive.posts');
Route::get('/author/{user:username}',[HomeController::class,'author'])->name('author.posts');

Route::group(['prefix'=>'user','as'=>'user.','middleware'=>"auth"],function(){
    Route::get('/dashboard',[UserController::class,'index'])->name('dashboard');
    Route::get('/create-post',[UserController::class,'create_post'])->name('create.post');
    Route::post('/create-post',[UserController::class,'store_post'])->name('store.post');
    Route::get('/edit-post/{post:slug}',[UserController::class,'edit_post'])->name('edit.post');
    Route::post('/edit-post/{post:slug}',[UserController::class,'update_post'])->name('update.post');
    Route::delete('/delete-post/{post:slug}',[UserController::class,'destroy_post'])->name('destroy.post');
    Route::post('/delete-post-media/{media_id}',[UserController::class,'destroy_post_media'])->name('post.media.destroy');
    Route::get('/comments',[UserController::class,'show_comments'])->name('comments');
    Route::get('/comments/{id}/edit',[UserController::class,'edit_comment'])->name('comment.edit');
    Route::post('/comments/{comment:id}/update',[UserController::class,'update_comment'])->name('comment.update');
    Route::delete('/comments/{comment:id}/destroy',[UserController::class,'destroy_comment'])->name('comment.destroy');
});