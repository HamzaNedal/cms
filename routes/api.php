<?php

use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Backend\Api\ApiController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
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
    Route::get('/get-posts',[GeneralController::class,'get_posts']);
    Route::get('/show-post/{slug}',[GeneralController::class,'show_post']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::get('/chart/comments_chart',[ApiController::class,'comments_charts']);
Route::get('/chart/users_chart',[ApiController::class,'users_charts']);

