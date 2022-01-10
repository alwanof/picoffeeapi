<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

Route::post('/token/create', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    if (!Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token= $user->createToken($request->device_name)->plainTextToken;

    $response = [
        'status' => '200',
        'data' => [
            'user' => $user,
            'token' => $token,
        ],
    ];

    return response()->json($response);
});

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::get('/user', function (Request $request) { return $request->user(); });

        Route::post('/token/delete', function (Request $request) {

            $request->user()->currentAccessToken()->delete();

            $response = [
                'status' => '204',
                'data' => 'token was deleted',
            ];

            return response()->json($response);
        });

        // Comment

        Route::apiResource('/comment',CommentController::class);


    }
);

Route::get('/test', function () { return 'test is here'; });


