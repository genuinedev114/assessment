<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
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

Route::view('/sample', 'sample');


Route::middleware(['guest'])->group(function () {
    Route::get('/login', 'App\Http\Controllers\Auth\LoginController@show')->name('login');
    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@store');
    Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@show')->name('register');
    Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@store');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@destroy')->name('logout');
    

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard/brand/{brand}/switch', [DashboardController::class, 'switchBrand'])->name('dashboard.switchBrand');
    Route::get('/dashboard/stores', [DashboardController::class, 'stores'])->name('dashboard.stores');
    Route::get('/dashboard/store/{store}', [DashboardController::class, 'storeDetail'])->name('dashboard.storeDetail');
    Route::get('/dashboard/journals', [DashboardController::class, 'journals'])->name('dashboard.journals');
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');


    Route::post('/export/store/{store}', [ExportController::class, 'store'])->name('export.store');
    Route::post('/export/all', [ExportController::class, 'all'])->name('export.all');
    Route::get('/export/all', [ExportController::class, 'downloads'])->name('export.all.get');
    Route::get('/export/downloads', [ExportController::class, 'downloads'])->name('export.downloads');
    Route::get('/export/download/{filename}', [ExportController::class, 'download'])
        ->where('filename', '[^/]+')
        ->name('export.download.file');
});

