<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Ustadz;
use App\Http\Controllers\WaliMurid;
use Illuminate\Support\Facades\Route;

// ============================================
// Public / Landing
// ============================================

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// ============================================
// Dashboard Redirect berdasarkan Role
// ============================================

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('ustadz')) {
        return redirect()->route('ustadz.dashboard');
    } elseif ($user->hasRole('wali_murid')) {
        return redirect()->route('wali-murid.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================
// Profile (bawaan Breeze)
// ============================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// Admin Routes
// ============================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Kegiatan Pondok CRUD
    Route::resource('kegiatan', Admin\KegiatanPondokController::class);

    // Santri CRUD
    Route::resource('santri', Admin\SantriController::class)->except(['show']);

    // Ustadz CRUD
    Route::resource('ustadz', Admin\UstadzController::class);

    // Admin Reports (Laporan)
    Route::get('/laporan/presensi-ustadz', [\App\Http\Controllers\Admin\LaporanController::class, 'presensiUstadz'])->name('laporan.presensi-ustadz');
    Route::get('/laporan/presensi-santri', [\App\Http\Controllers\Admin\LaporanController::class, 'presensiSantri'])->name('laporan.presensi-santri');
    Route::get('/laporan/hafalan', [\App\Http\Controllers\Admin\LaporanController::class, 'hafalan'])->name('laporan.hafalan');
    Route::get('/laporan/murojaah', [\App\Http\Controllers\Admin\LaporanController::class, 'murojaah'])->name('laporan.murojaah');

    // Wali Murid CRUD
    Route::resource('wali-murid', Admin\WaliMuridController::class)
         ->parameters(['wali-murid' => 'waliMurid']);

    // Penugasan Ustadz → Kegiatan
    Route::get('/penugasan-kegiatan', [Admin\UstadzKegiatanController::class, 'index'])->name('penugasan-kegiatan.index');
    Route::put('/penugasan-kegiatan/{ustadz}', [Admin\UstadzKegiatanController::class, 'update'])->name('penugasan-kegiatan.update');

    // Penugasan Santri Binaan → Ustadz
    Route::get('/santri-binaan', [Admin\UstadzSantriController::class, 'index'])->name('santri-binaan.index');
    Route::put('/santri-binaan/{ustadz}', [Admin\UstadzSantriController::class, 'update'])->name('santri-binaan.update');
});

// ============================================
// Ustadz Routes
// ============================================

Route::middleware(['auth', 'role:ustadz'])->prefix('ustadz')->name('ustadz.')->group(function () {

    Route::get('/dashboard', [Ustadz\DashboardController::class, 'index'])->name('dashboard');

    // Presensi Kegiatan (form + geolocation)
    Route::get('/presensi-kegiatan', [Ustadz\PresensiKegiatanController::class, 'index'])->name('presensi-kegiatan.index');
    Route::get('/presensi-kegiatan/create', [Ustadz\PresensiKegiatanController::class, 'create'])->name('presensi-kegiatan.create');
    Route::post('/presensi-kegiatan', [Ustadz\PresensiKegiatanController::class, 'store'])->name('presensi-kegiatan.store');
    Route::get('/presensi-kegiatan/{presensiKegiatan}', [Ustadz\PresensiKegiatanController::class, 'show'])->name('presensi-kegiatan.show');

    // Presensi Santri (hanya setelah presensi ustadz valid)
    Route::get('/presensi-santri/{presensiKegiatan}/create', [Ustadz\PresensiSantriController::class, 'create'])->name('presensi-santri.create');
    Route::post('/presensi-santri/{presensiKegiatan}', [Ustadz\PresensiSantriController::class, 'store'])->name('presensi-santri.store');

    // Setoran Hafalan
    Route::get('/setoran-hafalan', [Ustadz\SetoranHafalanController::class, 'index'])->name('setoran-hafalan.index');
    Route::get('/setoran-hafalan/create', [Ustadz\SetoranHafalanController::class, 'create'])->name('setoran-hafalan.create');
    Route::post('/setoran-hafalan', [Ustadz\SetoranHafalanController::class, 'store'])->name('setoran-hafalan.store');
    Route::get('/setoran-hafalan/{setoranHafalan}', [Ustadz\SetoranHafalanController::class, 'show'])->name('setoran-hafalan.show');

    // Murojaah
    Route::get('/murojaah', [Ustadz\MurojaahController::class, 'index'])->name('murojaah.index');
    Route::get('/murojaah/create', [Ustadz\MurojaahController::class, 'create'])->name('murojaah.create');
    Route::post('/murojaah', [Ustadz\MurojaahController::class, 'store'])->name('murojaah.store');
    Route::get('/murojaah/{murojaah}', [Ustadz\MurojaahController::class, 'show'])->name('murojaah.show');
});

// ============================================
// Wali Murid Routes
// ============================================

Route::middleware(['auth', 'role:wali_murid'])->prefix('wali-murid')->name('wali-murid.')->group(function () {

    Route::get('/dashboard', [WaliMurid\DashboardController::class, 'index'])->name('dashboard');

    // Laporan Mingguan
    Route::get('/laporan-mingguan', [WaliMurid\LaporanMingguanController::class, 'index'])->name('laporan-mingguan.index');

    // Riwayat Kegiatan
    Route::get('/riwayat-kegiatan', [WaliMurid\RiwayatKegiatanController::class, 'index'])->name('riwayat-kegiatan.index');
});

require __DIR__.'/auth.php';
