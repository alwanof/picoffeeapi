<?php

use App\Http\Controllers\UserController;
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

//register new user route
Route::post('/users/register', [\App\Http\Controllers\UserController::class, 'store']);

//login an existed user route
Route::post('/users/login', [\App\Http\Controllers\UserController::class, 'index']);

Route::group(
    ['middleware' => ['auth:sanctum']], 
    function () {
        Route::get('/user', function (Request $request) { return $request->user(); });
        Route::post('/users/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    }
);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/test', function (Request $request) { return 'test is here'; });