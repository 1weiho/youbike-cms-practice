<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AreaController::class, 'listAll']);

Route::group(['prefix' => 'menu'], function () {
    Route::get('/', [MenuController::class, 'listAll'])->name('menu.list');
    Route::get('/add', function () {
        return view('menu-add');
    });
    Route::get('/edit/{id}', [MenuController::class, 'listOne']);

    Route::post('/add', [MenuController::class, 'create'])->name('menu.create');
    Route::delete('/{id}', [MenuController::class, 'delete'])->name('menu.delete');
    Route::put('/{id}', [MenuController::class, 'update'])->name('menu.update');
});

Route::group(['prefix' => 'area'], function () {
    Route::get('/', [AreaController::class, 'listAll'])->name('area.list');
    Route::get('/add', function () {
        return view('area-add');
    });
    Route::get('/edit/{id}', [AreaController::class, 'listOne']);

    Route::post('/add', [AreaController::class, 'create'])->name('area.create');
    Route::delete('/{id}', [AreaController::class, 'delete'])->name('area.delete');
    Route::put('/{id}', [AreaController::class, 'update'])->name('area.update');
});

Route::group(['prefix' => 'news'], function () {
    Route::get('/', function () {
        return view('news-list');
    });
    Route::get('/add', function () {
        return view('news-add');
    });
    Route::get('/edit/{id}', function () {
        return view('news-edit');
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('admin-list');
    });
    Route::get('/add', function () {
        return view('admin-add');
    });
    Route::get('/edit/{id}', function () {
        return view('admin-edit');
    });
    Route::get('/reset-password/{id}', function () {
        return view('admin-reset-password');
    });
});

Route::get('/login', function () {
    return view('login');
});