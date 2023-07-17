<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

Route::middleware(['auth'])->group(function () {
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
        Route::get('/', [NewsController::class, 'listPage'])->name('news.list');
        Route::get('/add', [NewsController::class, 'addPage'])->name('news.add');
        Route::get('/edit/{id}', [NewsController::class, 'editPage'])->name('news.edit');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'listPage'])->name('admin.list');
        Route::get('/add', [AdminController::class, 'addPage'])->name('admin.add');
        Route::get('/edit/{id}', [AdminController::class, 'editPage'])->name('admin.edit');
        Route::get('/reset-password/{id}', [AdminController::class, 'resetPasswordPage'])->name('admin.reset-password');
    });

    Route::group(['prefix' => 'role-permission'], function () {
        Route::get('/', [RolePermissionController::class, 'listPage'])->name('role-permission.list');
        Route::get('/add', [RolePermissionController::class, 'addPage'])->name('role-permission.add');
        Route::get('/edit/{id}', [RolePermissionController::class, 'editPage'])->name('role-permission.edit');
    });
});


Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('lang/{locale}', function ($locale) {
    if (isset($locale) && in_array($locale, config('app.available_locales'))) {
        session()->put('locale', $locale);
    }

    return redirect()->back();
});
Route::get('/lang', function () {
    $lang = session()->get('locale');
    return $lang;
});
