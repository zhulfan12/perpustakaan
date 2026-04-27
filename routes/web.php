<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('buku', BukuController::class);
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('laporan', [LaporanController::class, 'index']);
});

Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('/pinjam', [PeminjamanController::class, 'index']);
    Route::post('/pinjam/{id}', [PeminjamanController::class, 'store']);
    Route::post('/kembali/{id}', [PeminjamanController::class, 'kembali']);
});



require __DIR__ . '/auth.php';
