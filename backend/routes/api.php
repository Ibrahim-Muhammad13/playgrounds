<?php

use App\Http\Controllers\Api\categoryController;
use App\Http\Controllers\Api\PlaygroundController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RateController;
use App\Http\Controllers\Api\TimeSlotsController;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\AuthController;
use App\Models\Playground;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ComplaintController;

use App\Http\Controllers\Api\ChatController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('a','a');
    Route::get('sendmail','sendmail');
    
});

Route::get('playground/search',[PlaygroundController::class,'search']);


Route::resource('user', userController::class);
Route::get('review/playground/{playground}',[ReviewController::class,'showByPlayground']);

//should be logged in to access
Route::middleware('auth:api')->group(function () {
    Route::resource('review', ReviewController::class)->except(['index', 'show']);

    Route::post('/complaints', [ComplaintController::class, 'store']);
});

//shoudl be logged in as admin to access
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::put('playground/changeStatus/{playground}',[PlaygroundController::class,'changeStates']);
    Route::put('playground/rejected/{playground}',[PlaygroundController::class,'rejected']);
    Route::get('playground/pending',[PlaygroundController::class,'pending']);
    Route::post('playgrounds/add-admin', [PlaygroundController::class, 'addAdmin']);
    Route::resource('category', categoryController::class)->except(['index', 'show']);
    Route::get('/complaints', [ComplaintController::class, 'index']);
});

//should be logged in as owner to access
Route::middleware(['auth:api', 'owner'])->group(function () {
    Route::resource('playground', PlaygroundController::class)->except(['index', 'show']);
    Route::get('playground/owner/{user}',[PlaygroundController::class,'playgroundByOwner']);

});

Route::resource('review', ReviewController::class, ['only' => ['index', 'show']]);
// Route::resource('review', ReviewController::class);
// Route::resource('rating', RateController::class);
// Route::put('rating/changeReview',[RateController::class,'update']);
Route::resource('category', categoryController::class)->only(['index', 'show']);
// Route::resource('category', categoryController::class);
Route::resource('playground', PlaygroundController::class)->only(['index', 'show']);


Route::post('playground/create2',[PlaygroundController::class,'store2']);
Route::get('playgrounds/top-rated', [PlaygroundController::class,'topRatedPlayground']);



Route::post('playground/create2',[PlaygroundController::class,'store2']);

// for chating 
Route::post('chat/send-message', [ChatController::class, 'sendMessage']);
Route::post('chat/get-messages', [ChatController::class, 'getChatMessages']);


Route::resource('timeslot', TimeSlotsController::class);

// for complaint messages



