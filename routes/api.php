<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\LoggerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RolePermissionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['action.logger'])->group(function () {
    Route::apiResource('news', NewsController::class);
    Route::post('news/{id}', [NewsController::class, 'modify']);
    Route::get('menu', [MenuController::class, 'index']);
    Route::get('area', [AreaController::class, 'index']);
    
    Route::apiResource('admin', AdminController::class);
    Route::post('admin/reset-password/{id}', [AdminController::class, 'resetPassword']);
    
    Route::apiResource('role-permission', RolePermissionController::class);

    Route::get('logger', [LoggerController::class, 'index']);
});