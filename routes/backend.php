<?php

use App\Http\Controllers\Backend\ConfigController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('configs/items', [ConfigController::class, 'configItems']);

Route::middleware('api')->group(function () {
    Route::prefix('configs')->group(function () {
        Route::get('', [ConfigController::class, 'index']);
        Route::get('group', [ConfigController::class, 'group']);
        Route::put('group', [ConfigController::class, 'groupUpdate']);
        Route::get('{config}', [ConfigController::class, 'show']);
        Route::post('', [ConfigController::class, 'store']);
        Route::put('{config}', [ConfigController::class, 'update']);
        Route::delete('{config}', [ConfigController::class, 'destroy']);
    });
});
