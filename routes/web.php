<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION (Guest only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Auth required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // SISWA
    Route::get('/siswas', [SiswaController::class, 'index'])->name('siswas.index');
    Route::get('/siswas/create', [SiswaController::class, 'create'])->name('siswas.create');
    Route::post('/siswas', [SiswaController::class, 'store'])->name('siswas.store');
    Route::get('/siswas/{id}/edit', [SiswaController::class, 'edit'])->name('siswas.edit');
    Route::put('/siswas/{id}', [SiswaController::class, 'update'])->name('siswas.update');
    Route::delete('/siswas/{id}', [SiswaController::class, 'destroy'])->name('siswas.destroy');

    // BUKU
    Route::resource('bukus', BukuController::class);

    // KATEGORI
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
    Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
    Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
    Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

    // PEMINJAMAN
    Route::get('/peminjamans', [PeminjamanController::class, 'index'])->name('peminjamans.index');
    Route::get('/peminjamans/create', [PeminjamanController::class, 'create'])->name('peminjamans.create');
    Route::get('/peminjamans/riwayat', [PeminjamanController::class, 'riwayat'])->name('peminjamans.riwayat');
    Route::post('/peminjamans', [PeminjamanController::class, 'store'])->name('peminjamans.store');
    Route::get('/peminjamans/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjamans.edit');
    Route::put('/peminjamans/{id}', [PeminjamanController::class, 'update'])->name('peminjamans.update');
    Route::put('/peminjamans/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjamans.kembalikan');
    Route::delete('/peminjamans/{id}', [PeminjamanController::class, 'destroy'])->name('peminjamans.destroy');

});