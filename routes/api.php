<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/name/update', [AuthController::class, 'nameUpdate']);
    Route::post('/password/update', [AuthController::class, 'passwordUpdate']);
    Route::post('/profile/update', [AuthController::class, 'profileUpdate']);
    Route::get('/user/info', [AuthController::class, 'userInfo']);

    Route::prefix('post')->group(function (){
        Route::get('list',[PostController::class,'index']);
        Route::get('show/{id}',[PostController::class,'show']);
    });

    Route::prefix('comment')->group(function (){
        Route::post('create',[PostCommentController::class,'store']);
        Route::post('delete',[PostCommentController::class,'destroy']);
    });
    Route::middleware(['role:admin'])->group(function (){
        Route::prefix('post')->group(function (){
            Route::post('create',[PostController::class,'store']);
        });
    });
});
