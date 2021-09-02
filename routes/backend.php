<?php

use App\Http\Controllers\Backend\ConfigController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UploadController;
use App\Http\Controllers\Backend\UserController;
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
Route::post('/uploads', [UploadController::class, 'normal']);

Route::middleware('api')->group(function () {
    Route::prefix('configs')->group(function () {
        Route::get('', [ConfigController::class, 'index']);
        Route::post('', [ConfigController::class, 'store']);
        Route::get('group', [ConfigController::class, 'group']);
        Route::put('group', [ConfigController::class, 'groupUpdate']);
        Route::get('{config}', [ConfigController::class, 'show']);
        Route::put('{config}', [ConfigController::class, 'update']);
        Route::delete('{config}', [ConfigController::class, 'destroy']);
    });

    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index']);
        Route::post('', [UserController::class, 'store']);
        Route::get('{user}', [UserController::class, 'show']);
        Route::put('{user}', [UserController::class, 'update']);
        Route::delete('{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('roles')->group(function () {
        Route::get('', [RoleController::class, 'index']);
        Route::post('', [RoleController::class, 'store']);
        Route::get('{role}', [RoleController::class, 'show']);
        Route::put('{role}', [RoleController::class, 'update']);
        Route::delete('{role}', [RoleController::class, 'destroy']);
    });

    Route::prefix('permissions')->group(function () {
        Route::get('', [PermissionController::class, 'index']);
        Route::post('', [PermissionController::class, 'store']);
        Route::get('{permission}', [PermissionController::class, 'show']);
        Route::put('{permission}', [PermissionController::class, 'update']);
        Route::delete('{permission}', [PermissionController::class, 'destroy']);
    });

});
