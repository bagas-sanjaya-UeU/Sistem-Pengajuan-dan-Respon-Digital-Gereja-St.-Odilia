<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PengajuanController;
use App\Http\Controllers\Dashboard\ResponController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\TableauController;

// Rute Halaman Utama
Route::get('/', function () {
    return view('pages.home'); // atau redirect ke login
})->name('home');

// Rute Autentikasi
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('login', [AuthController::class, 'login'])->name('auth.login');
// Rute untuk Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk Halaman Registrasi (jika ada)
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');

// Grup Rute untuk Dashboard yang Memerlukan Autentikasi
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Rute untuk halaman utama dashboard
    // Rute utama dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk Pengajuan (sebagian besar resource kecuali edit dan update)
    Route::resource('pengajuans', PengajuanController::class)->except(['edit']);

    // Rute untuk Respon (hanya bisa diakses oleh admin)
    Route::post('pengajuans/{pengajuan}/respon', [ResponController::class, 'store'])
        ->name('respons.store')->middleware('can:admin'); // Contoh penggunaan middleware/gate

    // Rute untuk Manajemen User (hanya bisa diakses oleh admin)
    Route::resource('users', UserController::class)->middleware('can:admin');
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index')->middleware('can:admin');
    Route::get('laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak')->middleware('can:admin');
    Route::resource('tableau', TableauController::class)->middleware('can:admin');

});