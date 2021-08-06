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

Route::get('/cakes', [App\Http\Controllers\Api\ApiController::class, 'index']);
Route::post('/cake', [App\Http\Controllers\Api\ApiController::class, 'store']);
Route::get('/cake/{id}', [App\Http\Controllers\Api\ApiController::class, 'show']);
Route::put('/cake/{id}', [App\Http\Controllers\Api\ApiController::class, 'update']);
Route::delete('/cake/{id}', [App\Http\Controllers\Api\ApiController::class, 'destroy']);
