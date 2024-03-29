<?php

use App\Http\Controllers\Backend\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Backend\Auth\ResetPasswordController as AuthResetPasswordController;
use App\Http\Controllers\Backend\Auth\VerificationController as AuthVerificationController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\HomeController as BackendHomeController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\PostCategoriesController;
use App\Http\Controllers\Backend\PostCommentsController;
use App\Http\Controllers\Backend\PostsController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SupervisorsController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\VerificationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\UserController;
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
Route::get('/test',function ()
{
   dd(asset('image'));
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

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

    Route::group(['middleware' => ['roles', 'role:admin|editor']], function () {

        Route::get('/', [BackendHomeController::class, 'index'])->name('home');
        Route::get('/index', [BackendHomeController::class, 'index'])->name('index');
       

        Route::resources([
            'posts' => PostsController::class,
            'pages' => PagesController::class,
            'post_comments' => PostCommentsController::class,
            'post_categories' => PostCategoriesController::class,
            'users' => UsersController::class,
            'contact_us' => ContactUsController::class,
            'supervisors' => SupervisorsController::class,
            'settings' => SettingsController::class,
        ]);
        Route::get('/posts-datatable', [PostsController::class, 'datatable'])->name('posts.datatable');
        Route::post('/delete-post-media/{media_id}', [PostsController::class, 'destroy_post_media'])->name('post.media.destroy');
        Route::get('/post-categories-datatable', [PostCategoriesController::class, 'datatable'])->name('post_categories.datatable');
        Route::get('/post-comments-datatable', [PostCommentsController::class, 'datatable'])->name('post_comments.datatable');
        Route::get('/pages-datatable', [PagesController::class, 'datatable'])->name('pages.datatable');
        Route::get('/contact_us-datatable', [ContactUsController::class, 'datatable'])->name('contact_us.datatable');
        Route::get('/users-datatable', [UsersController::class, 'datatable'])->name('users.datatable');
        Route::get('/supervisors-datatable', [SupervisorsController::class, 'datatable'])->name('supervisors.datatable');
        Route::post('/delete-user-media', [UsersController::class, 'removeImage'])->name('user.media.destroy');
       
    });
});



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.home');
Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact');
Route::post('/contact-us', [HomeController::class, 'store_contact_us'])->name('store.contact');
Route::get('/{page_slug}', [HomeController::class, 'show_page'])->name('pages.show');
Route::get('/post/{post}', [HomeController::class, 'show_post'])->name('posts.show');
Route::post('/{post:slug}', [HomeController::class, 'store_comment'])->name('add.comment');
Route::get('/posts/search', [HomeController::class, 'search'])->name('posts.search');
Route::get('/category/{category:slug}', [HomeController::class, 'category'])->name('category.posts');
Route::get('/archive/{date}', [HomeController::class, 'archive'])->name('archive.posts');
Route::get('/author/{user:username}', [HomeController::class, 'author'])->name('author.posts');

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => "auth"], function () {

    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/create-post', [UserController::class, 'create_post'])->name('create.post');
    Route::post('/create-post', [UserController::class, 'store_post'])->name('store.post');
    Route::get('/edit-post/{post:slug}', [UserController::class, 'edit_post'])->name('edit.post');
    Route::post('/edit-post/{post:slug}', [UserController::class, 'update_post'])->name('update.post');
    Route::delete('/delete-post/{post:slug}', [UserController::class, 'destroy_post'])->name('destroy.post');
    Route::post('/delete-post-media/{media_id}', [UserController::class, 'destroy_post_media'])->name('post.media.destroy');
    Route::get('/comments', [UserController::class, 'show_comments'])->name('comments');
    Route::get('/comments/{id}/edit', [UserController::class, 'edit_comment'])->name('comment.edit');
    Route::post('/comments/{comment:id}', [UserController::class, 'update_comment'])->name('comment.update');
    Route::delete('/comments/{comment:id}', [UserController::class, 'destroy_comment'])->name('comment.destroy');
    Route::get('/edit-info', [UserController::class, 'edit_info'])->name('edit_info');
    Route::post('/edit-info', [UserController::class, 'update_info'])->name('update_info');
    Route::post('/edit-password', [UserController::class, 'update_password'])->name('update_password');
    Route::any('/notifications/get', [NotificationController::class, 'getNotifications']);
    Route::any('/notifications/read', [NotificationController::class, 'markAsRead']);
    Route::any('/notifications/read{id}', [NotificationController::class, 'markAsReadAndRedirect']);
});
