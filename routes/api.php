<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;

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

// RegistrationController
Route::post('user/register', [RegistrationController::class, 'register']);

// AuthController
Route::post('user/login', [AuthController::class, 'login']);

Route::post('image/upload', [ImageController::class, 'upload']);
Route::post('image/getPhotoPath', [ImageController::class, 'getPhotoPath']);
// Route::post('image/upload', [ImageController::class, 'upload']);
// Route::post('image/uploadPhotos', [ImageController::class, 'uploadPhotos']);


Route::middleware(['web', 'jwt.auth'])->group(function () 
{

    Route::post('user/logout', [AuthController::class, 'logout']);

    Route::resource('post', PostController::class, [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);

    Route::resource('group', GroupController::class, [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);

    Route::resource('comment', CommentController::class, [
        'only' => ['index', 'show', 'store', 'update', 'destroy']
    ]);
    Route::resource('data', UserController::class, [
        'only' => ['index', 'show', 'store', 'update', 'destroy', 'getExternalData']
    ]);

    Route::post('image/uploadPhotos', [ImageController::class, 'uploadPhotos']);
    Route::get('image/getPhotos/{postId}', [ImageController::class, 'getPhotosByPostId']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
