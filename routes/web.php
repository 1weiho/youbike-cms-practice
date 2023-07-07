<?php

use App\Http\Controllers\MenuController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', [MenuController::class, 'listAll']);
Route::get('/menu/add', function () {
    return view('menu-add');
});
Route::get('/menu/edit/{id}', [MenuController::class, 'listOne']);

Route::post('/menu/add', [MenuController::class, 'create'])->name('menu.create');
Route::delete('/menu/{id}', [MenuController::class, 'delete'])->name('menu.delete');
Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
