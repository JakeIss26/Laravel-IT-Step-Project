<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabinetController;
use App\Models\Cabinet;
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

Route::get('/hello', [CabinetController::class, 'hello']);
Route::get('/get', [CabinetController::class, 'get']);
Route::get('/get/{id}', [CabinetController::class, 'getById']);
Route::post('/post', [CabinetController::class, 'post']);
Route::put('/put/{id}', [CabinetController::class, 'put']);
Route::delete('/delete/{id}', [CabinetController::class, 'delete']);
Route::post('/create', [CabinetController::class, 'create']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
