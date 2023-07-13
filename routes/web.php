<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
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
        Route::get('/', function () {
            return view('news-list')->with('lang', json_encode(__('lang')));
        });
        Route::get('/add', function () {
            return view('news-add')->with('lang', json_encode(__('lang')));;
        });
        Route::get('/edit/{id}', function () {
            return view('news-edit')->with('lang', json_encode(__('lang')));;
        });
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return view('admin-list')->with('lang', json_encode(__('lang')));
        });
        Route::get('/add', function () {
            return view('admin-add')->with('lang', json_encode(__('lang')));;
        });
        Route::get('/edit/{id}', function () {
            return view('admin-edit')->with('lang', json_encode(__('lang')));;
        });
        Route::get('/reset-password/{id}', function () {
            return view('admin-reset-password')->with('lang', json_encode(__('lang')));;
        });
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
Route::get('/lang', function() {
    $lang = session()->get('locale');
    return $lang;
});
