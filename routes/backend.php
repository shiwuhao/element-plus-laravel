<?php

use App\Http\Controllers\Backend\ActionController;
use App\Http\Controllers\Backend\ConfigController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\MenuController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PersonalController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\TestController;
use App\Http\Controllers\Backend\UploadController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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


Route::post('login', [LoginController::class, 'loginByPassword']);// 登录
Route::post('logout', [LoginController::class, 'logout']);// 登出

Route::post('/uploads', [UploadController::class, 'normal']);

\Route::middleware(['auth:sanctum', 'permission'])->group(function () {
    Route::get('test', [TestController::class, 'index']);
});

Route::prefix('configs')->group(function () {
    Route::get('items', [ConfigController::class, 'configItems']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('personal')->group(function () {
        Route::get('info', [PersonalController::class, 'info']);
        Route::get('permissions', [PersonalController::class, 'permissions']);
    });

    Route::middleware('permission')->group(function () {
        Route::prefix('configs')->group(function () {
            Route::get('', [ConfigController::class, 'index']);
            Route::post('', [ConfigController::class, 'store']);
//            Route::get('items', [ConfigController::class, 'configItems']);
            Route::get('group', [ConfigController::class, 'group']);
            Route::put('group', [ConfigController::class, 'groupUpdate']);
            Route::get('{config}', [ConfigController::class, 'show']);
            Route::put('{config}', [ConfigController::class, 'update']);
            Route::delete('{config}', [ConfigController::class, 'destroy']);
        });


        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);

        Route::get('actions/all', [ActionController::class, 'all']);
        Route::apiResource('actions', ActionController::class);

        Route::get('menus/all', [MenuController::class, 'all']);
        Route::apiResource('menus', MenuController::class);

        Route::get('permissions/all', [PermissionController::class, 'all']);
        Route::post('/permissions/auto', [PermissionController::class, 'autoGenerate']);
        Route::apiResource('permissions', PermissionController::class);

    });

});
