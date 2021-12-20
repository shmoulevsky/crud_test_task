<?php

use App\Http\Controllers\ApiV1\ArticleController;
use App\Http\Controllers\ApiV1\UserController;
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

Route::group(['prefix' => 'v1'], function () {

    Route::post('register', [UserController::class, "register"]);
    Route::post('login', [UserController::class, "login"]);

    Route::group(['middleware' => ['auth:sanctum', 'throttle:15,1']], function () {

        Route::get('/users', [UserController::class, 'index']);

        Route::resource('articles', ArticleController::class)->except([
            'create', 'edit'
        ]);

    });

});
