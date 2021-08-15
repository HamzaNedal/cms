<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Backend\Api\ApiController;
// use App\Http\Controllers\Frontend\Auth\LoginController;
// use App\Http\Controllers\Frontend\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    Route::get('/get-posts',[GeneralController::class,'get_posts'])->middleware('auth:api');
    Route::get('/show-post/{slug}',[GeneralController::class,'show_post'])->middleware('auth:api');
    Route::get('/posts/search', [GeneralController::class, 'search']);
    Route::get('/category/{slug}', [GeneralController::class, 'category']);
    Route::get('/tags/{slug}', [GeneralController::class, 'tag']);
    Route::get('/author/{user}', [GeneralController::class, 'author']);
    Route::post('/add/comment/{slug}', [GeneralController::class, 'store_comment']);
    Route::post('/contact-us', [GeneralController::class, 'store_contact_us']);
    Route::get('/show-post-comments/{slug}', [GeneralController::class, 'get_post_comments']);

    // Route::post('/login', [LoginController::class, 'login']);
    // Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refersh_token', [AuthController::class, 'refersh_token']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/my-posts', [UserController::class, 'my_posts']);
        Route::get('/my-posts/create', [UserController::class, 'create']);
        Route::post('/my-posts/create', [UserController::class, 'store_post']);
        Route::get('/my-posts/{post}/edit', [UserController::class, 'edit_post']);
        Route::put('/my-posts/{post}', [UserController::class, 'update_post']);
        Route::put('/my-posts/status/{id}', [UserController::class, 'updateStatus']);
        Route::delete('/my-posts/{post}', [UserController::class, 'destroy_post']);
        Route::get('/comments', [UserController::class, 'comments']);
        Route::get('/comment/{id}/edit', [UserController::class, 'edit_comment']);
        Route::put('/comment/{id}', [UserController::class, 'update_comment']);
        Route::delete('/comment/{id}', [UserController::class, 'destroy_comment']);

        Route::get('/notifications/get', [UserController::class, 'getNotifications']);
        Route::post('/notifications/read/{id}', [UserController::class, 'markAsRead']);
        
        Route::post('/logout', [UserController::class, 'logout']);
    });
});

Route::get('/chart/comments_chart',[ApiController::class,'comments_charts']);
Route::get('/chart/users_chart',[ApiController::class,'users_charts']);

