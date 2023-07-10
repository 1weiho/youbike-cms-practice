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

/* Menu */
Route::get('/menu', [MenuController::class, 'listAll']);
Route::get('/menu/add', function () {
    return view('menu-add');
});
Route::get('/menu/edit/{id}', [MenuController::class, 'listOne']);

Route::post('/menu/add', [MenuController::class, 'create'])->name('menu.create');
Route::delete('/menu/{id}', [MenuController::class, 'delete'])->name('menu.delete');
Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');

/* Area */
Route::get('/area', [AreaController::class, 'listAll']);
Route::get('/area/add', function () {
    return view('area-add');
});
Route::get('/area/edit/{id}', [AreaController::class, 'listOne']);

Route::post('/area/add', [AreaController::class, 'create'])->name('area.create');
Route::delete('/area/{id}', [AreaController::class, 'delete'])->name('area.delete');
Route::put('/area/{id}', [AreaController::class, 'update'])->name('area.update');

/* News */
Route::get('/news', function () {
    return view('news-list');
});
Route::get('/news/add', function () {
    return view('news-add');
});
Route::get('/news/edit/{id}', function () {
    return view('news-edit');
});
