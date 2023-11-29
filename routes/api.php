<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Models\Cabinet;
use App\Models\User;
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

// CabinetController
Route::get('/hello', [CabinetController::class, 'hello']);
Route::get('/get', [CabinetController::class, 'get']);
Route::get('/get/{id}', [CabinetController::class, 'getById']);
Route::post('/post', [CabinetController::class, 'post']);
Route::put('/put/{id}', [CabinetController::class, 'put']);
Route::delete('/delete/{id}', [CabinetController::class, 'delete']);
Route::post('/create', [CabinetController::class, 'create']);
// RegistrationController
Route::post('/register', [RegistrationController::class, 'register']);
// AuthController
Route::post('/login', [AuthController::class, 'login']);
// PostController
Route::get('/showPosts', [PostController::class, 'showPosts']);
Route::get('/getById/{id}', [PostController::class, 'getById']);
Route::post('/addPost', [PostController::class, 'addPost']);
Route::delete('/removePost/{id}', [PostController::class, 'removePost']);
Route::put('/updatePost/{id}', [PostController::class, 'updatePost']);
// GroupController
Route::get('/showGroups', [GroupController::class, 'showGroups']);
Route::get('/getById/{id}', [GroupController::class, 'getById']);
Route::post('/addGroup', [GroupController::class, 'addGroup']);
Route::delete('/removeGroup/{id}', [GroupController::class, 'removeGroup']);
Route::put('/updateGroup/{id}', [GroupController::class, 'updateGroup']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
