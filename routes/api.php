<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CountryController;

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

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });

Route::prefix('lynkr')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('countries')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [CountryController::class, 'index']);
        Route::post('/', [CountryController::class, 'store']);
        Route::put('/{code}', [CountryController::class, 'update']);
        Route::delete('/{code}', [CountryController::class, 'destroy']);
    });

    Route::prefix('brands')->group(function () {
        Route::middleware('user.country')->group(function () {
            Route::get('/', [BrandController::class, 'index']);
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('create/', [BrandController::class, 'store']);
            Route::put('edit/{brand}', [BrandController::class, 'update']);
            Route::get('/{brand}', [BrandController::class, 'show']);
            Route::delete('/{brand}', [BrandController::class, 'destroy']);
        });
    });
});
