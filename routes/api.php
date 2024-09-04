<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MutasiController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('barangs', BarangController::class);
    Route::apiResource('mutasis', MutasiController::class);
    Route::apiResource('users', UserController::class);
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('barangs/{id}/history', [MutasiController::class, 'historyForBarang']);
    Route::get('users/{id}/history', [MutasiController::class, 'historyForUser']);
});