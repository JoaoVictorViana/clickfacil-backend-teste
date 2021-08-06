<?php

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

Route::group(['prefix' => 'cake'], function() {
    Route::get('/', [App\Http\Controllers\Api\CakeController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\CakeController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\CakeController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\Api\CakeController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\CakeController::class, 'destroy']);
});

Route::group(['prefix' => 'email'], function() {
    Route::get('/', [App\Http\Controllers\Api\EmailCakeController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\EmailCakeController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\EmailCakeController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\Api\EmailCakeController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\EmailCakeController::class, 'destroy']);
    Route::post('/list', [App\Http\Controllers\Api\EmailCakeController::class, 'storeList']);
});
