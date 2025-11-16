<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PekebunController;
use App\Http\Controllers\KriteriaISPOController;
use App\Http\Controllers\PemetaanLahanController;
use App\Http\Controllers\InformasiISPOController;
use App\Http\Controllers\DSSController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Informasi ISPO Routes
    Route::resource('informasi', InformasiISPOController::class);


    // Kriteria ISPO Routes
    Route::resource('kriteria', KriteriaISPOController::class);

    // Pemetaan Lahan Routes - ADMIN
    Route::get('/pemetaan', [PemetaanLahanController::class, 'index'])->name('pemetaan.index');
    Route::get('/pemetaan/create', [PemetaanLahanController::class, 'create'])->name('pemetaan.create');
    Route::post('/pemetaan', [PemetaanLahanController::class, 'store'])->name('pemetaan.store');
    Route::get('/pemetaan/{id}/edit', [PemetaanLahanController::class, 'edit'])->name('pemetaan.edit');
    Route::put('/pemetaan/{id}', [PemetaanLahanController::class, 'update'])->name('pemetaan.update');
    Route::delete('/pemetaan/{id}', [PemetaanLahanController::class, 'destroy'])->name('pemetaan.destroy');
    Route::get('/pemetaan/{id}', [PemetaanLahanController::class, 'show'])->name('pemetaan.show');
    Route::get('/api/pemetaan-data', [PemetaanLahanController::class, 'getPemetaanData'])->name('api.pemetaan.data');

    // DSS Routes
    Route::get('/dss', [AdminController::class, 'dss'])->name('dss.index');
    Route::post('/dss/calculate', [AdminController::class, 'calculateDSS'])->name('dss.calculate');
    Route::get('/dss/riwayat', [DSSController::class, 'riwayatAdmin'])->name('dss.riwayat');
    Route::get('/dss/riwayat/{id}', [DSSController::class, 'showRiwayat'])->name('dss.riwayat.detail');

    // Untuk admin
    Route::get('/admin/dss/riwayat/{id}', [DSSController::class, 'showRiwayat'])
        ->name('admin.dss.riwayat.detail');
});

// Pekebun Routes
Route::middleware(['auth', 'pekebun'])->prefix('pekebun')->name('pekebun.')->group(function () {
    Route::get('/dashboard', [PekebunController::class, 'dashboard'])->name('dashboard');

    // Pemetaan Lahan Routes (Data Sendiri)
    Route::get('/pemetaan/map', [PemetaanLahanController::class, 'map'])->name('pemetaan.map');
    Route::get('/pemetaan/table', [PemetaanLahanController::class, 'table'])->name('pemetaan.table');

    // Pemetaan Lahan Routes (Semua Data) - BARU
    Route::get('/pemetaan/map-all', [PemetaanLahanController::class, 'mapAll'])->name('pemetaan.map-all');
    Route::get('/pemetaan/table-all', [PemetaanLahanController::class, 'tableAll'])->name('pemetaan.table-all');
    Route::resource('lahan', PemetaanLahanController::class);

    Route::get('/dss', [DSSController::class, 'index'])->name('dss.index');
    Route::post('/dss/hitung', [DSSController::class, 'hitungKesiapan'])->name('dss.hitung');
    Route::get('/dss/riwayat', [DSSController::class, 'riwayatPekebun'])->name('dss.riwayat');
    Route::get('/dss/riwayat/{id}', [DSSController::class, 'showRiwayat'])->name('dss.riwayat.detail');
    Route::get('/dss/penilaian-sebelumnya/{pemetaan_lahan_id}', [DSSController::class, 'getPenilaianSebelumnya'])->name('dss.penilaian.sebelumnya');

    // Untuk pekebun
    Route::get('/pekebun/dss/riwayat/{id}', [DSSController::class, 'showRiwayat'])
        ->name('pekebun.dss.riwayat.detail');
});
