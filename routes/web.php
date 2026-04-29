<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // buku untuk semua role
    Route::resource('buku', BukuController::class);

    // admin & petugas
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::middleware(['no-cache'])->group(function () {
            Route::get('/peminjaman-requests', [PeminjamanController::class, 'requests'])->name('peminjaman.requests');
            Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
            Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
        });

        Route::middleware(['auth', 'role:admin'])->group(function () {
            Route::resource('user', \App\Http\Controllers\UserController::class);
        });
    });

    Route::middleware(['role:peminjam'])->group(function () {
        Route::middleware(['no-cache'])->group(function () {
            Route::get('/pinjam', [PeminjamanController::class, 'index'])->name('pinjam.index');
            Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('pinjam.store');
        });
        Route::post('/kembali/{id}', [PeminjamanController::class, 'kembali'])->name('kembali');
    });

    // logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

require __DIR__ . '/auth.php';
