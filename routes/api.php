<?php


use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TweetController;
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


//create token for the new users
Route::post('/token/create', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    if (!Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'password' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    $response = [
        'status' => '200',
        'data' => [
            'user' => $user,
            'token' => $token,
        ],
    ];

    return response()->json($response);
});

//user register
Route::Post('/users/store',[UserController::class, 'store']);

Route::group(
    [
       'prefix' =>'v1',  'middleware' => ['auth:sanctum'],
    ],
    function () {
        //get user with current token
        Route::get('/me', function (Request $request) { return $request->user(); });

        //get the current user's token
        Route::get('/me/token', function (Request $request) { return response()->json(['token' => $request->bearerToken()]); });

        //delete current user token
        Route::post('/token/delete', function (Request $request) {

            $request->user()->currentAccessToken()->delete();

            $response = [
                'status' => '204',
                'data' => 'token was deleted',
            ];

            return response()->json($response);
        });


        //users
        Route::get('/users/index',[UserController::class, 'index']);

        Route::get('/users/show/{id}',[UserController::class, 'show']);

        Route::get('/users/tweets/{id}',[UserController::class, 'userTweets']);

        Route::get('/users/profile/{id}',[UserController::class, 'userProfile']);


        Route::post('/users/follow',[UserController::class, 'followUser']);

        Route::put('/users/update/{id}',[UserController::class, 'update']);

        Route::delete('/users/delete/{id}',[UserController::class, 'destroy']);


        // Comments
        Route::get('/comments', [CommentController::class, 'index']);

        Route::post('/comments/store', [CommentController::class, 'store']);

        Route::get('/comments/show/{comment_id}', [CommentController::class, 'show']);

        Route::put('/comments/update/{comment_id}', [CommentController::class, 'update']);

        Route::delete('/comments/delete/{comment_id}', [CommentController::class, 'destroy']);

        //profiles
        Route::get('/profiles/index', [ProfileController::class, 'index']);

        Route::get('/profiles/show/{id}', [ProfileController::class, 'show']);

        Route::post('/profiles/store', [ProfileController::class, 'store']);

        Route::delete('/profiles/destory/{id}', [ProfileController::class, 'destroy']);

        Route::put('/profiles/update/{id}', [ProfileController::class, 'update']);

        Route::patch('/profiles/edit/{id}', [ProfileController::class, 'edit']);



        //Tweet
        Route::get('/tweets', [TweetController::class, 'index']);
        Route::get('/tweets/{id}', [TweetController::class, 'show']);
        Route::get('/tweets/top', [TweetController::class, 'topTweets']);
        Route::get('/tweets/top/{id}', [TweetController::class, 'specificTopTweets']);
        Route::get('/tweets/comments/{id}', [TweetController::class, 'tweetComments']);
        Route::post('/tweets/store', [TweetController::class, 'store']);
        Route::post('/tweets/like', [TweetController::class, 'like']);//not working yet
        Route::put('/tweets/update/{id}', [TweetController::class, 'update']);
        Route::delete('/tweets/delete/{id}', [TweetController::class, 'destroy']);





    }
);
Route::get('/tweets/top', [TweetController::class, 'topTweets']);
Route::prefix('v1')->group(function () {
    Route::get('/test', function () { return 'test is here'; });
});
