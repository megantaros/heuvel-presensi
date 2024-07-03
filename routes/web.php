<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DashboardAnalyticsController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', DashboardAnalyticsController::class)->name('dashboard');

    Route::get('/absen', AbsenController::class)->name('absen');
    Route::post('/absen', [AbsenController::class, 'absen'])->name('absen.submit');

    Route::get('/history', [AbsenController::class, 'history'])->name('history');
});

Route::group(['middleware' => ['roles:1,2,3', 'auth']], function () {
    Route::resource('/users', UserController::class);

    Route::resource('/settings', SettingController::class);

    Route::get('/recap', [RekapController::class, 'index'])->name('recap');
    Route::get('/recap/{user}', RekapController::class)->name('recap.show');

    Route::get('/print-karyawan', [UserController::class, 'print'])->name('print.karyawan');
    Route::get('/print-rekapitulasi', [RekapController::class, 'print'])->name('print.rekapitulasi');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
});

Auth::routes();