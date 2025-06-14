<?php

use App\Http\Controllers\AktifitasController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KeuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [KeuanganController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/list', [KeuanganController::class, 'tampil'])->name('dashboard');
Route::post('/submit', [KeuanganController::class, 'submit'])->name('pages.submit');
Route::get('/edit/{id}', [KeuanganController::class, 'edit'])->name('pages.edit');
Route::put('/update/{id}', [KeuanganController::class, 'update'])->name('pages.update');
Route::post('/delete/{id}', [KeuanganController::class, 'delete'])->name('pages.delete');

Route::get('/filter-pemasukan', [KeuanganController::class, 'filterPemasukan'])->name('pages.filterPemasukan');
Route::get('/filter-pengeluaran', [KeuanganController::class, 'filterPengeluaran'])->name('pages.filterPengeluaran');

Route::get('/get-chart-data', [KeuanganController::class, 'getChartData'])->name('pages.getChartData');

Route::resource('categories', CategoryController::class)->middleware('auth');

Route::get('/aktivitas/pemasukan', [AktifitasController::class, 'pemasukan'])->name('aktivitas.pemasukan');
Route::get('/aktivitas/pengeluaran', [AktifitasController::class, 'pengeluaran'])->name('aktivitas.pengeluaran');


Route::get('/laporan/cetak', [App\Http\Controllers\LaporanController::class, 'cetak'])->name('cetak.laporan');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';
