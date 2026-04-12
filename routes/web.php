<?php

use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DamagedItemController;
use App\Http\Controllers\GoodItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StafController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get('identitas-sekolah', [SchoolController::class, 'index'])->name('school.index');
Route::put('identitas-sekolah', [SchoolController::class, 'update'])->name('school.update');

Route::get('master-staf-bengkel', [StafController::class, 'index'])->name('staf.index');
Route::post('master-staf-bengkel', [StafController::class, 'store'])->name('staf.store');
Route::put('master-staf-bengkel/{id}', [StafController::class, 'update'])->name('staf.update');
Route::delete('master-staf-bengkel/{id}', [StafController::class, 'destroy'])->name('staf.destroy');
Route::post('master-staf-bengkel/import-class', [StafController::class, 'import'])->name('staf.import');

Route::get('master-kelas', [ClassRoomController::class, 'index'])->name('class.index');
Route::post('master-kelas', [ClassRoomController::class, 'store'])->name('class.store');
Route::put('master-kelas/{id}', [ClassRoomController::class, 'update'])->name('class.update');
Route::delete('master-kelas/{id}', [ClassRoomController::class, 'destroy'])->name('class.destroy');
Route::post('master-kelas/import-class', [ClassRoomController::class, 'import'])->name('class.import');

Route::get('master-siswa', [UserController::class, 'index'])->name('user.index');
Route::post('master-siswa', [UserController::class, 'store'])->name('user.store');
Route::get('master-siswa/{id}/detail', [UserController::class, 'detail'])->name('user.detail');
Route::put('master-siswa/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('master-siswa/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::post('master-siswa/import-class', [UserController::class, 'import'])->name('user.import');

Route::get('lokasi-penyimpanan', [LocationController::class, 'index'])->name('location.index');
Route::post('lokasi-penyimpanan', [LocationController::class, 'store'])->name('location.store');
Route::put('lokasi-penyimpanan/{id}', [LocationController::class, 'update'])->name('location.update');
Route::delete('lokasi-penyimpanan/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
Route::post('lokasi-penyimpanan/import-class', [LocationController::class, 'import'])->name('location.import');

Route::get('barang-kondisi-baik', [GoodItemController::class, 'index'])->name('good.item.index');
Route::post('barang-kondisi-baik', [GoodItemController::class, 'store'])->name('good.item.store');
Route::put('barang-kondisi-baik/{id}', [GoodItemController::class, 'update'])->name('good.item.update');
Route::delete('barang-kondisi-baik/{id}', [GoodItemController::class, 'destroy'])->name('good.item.destroy');
Route::post('barang-kondisi-baik/import-class', [GoodItemController::class, 'import'])->name('good.item.import');

Route::get('barang-kondisi-rusak', [DamagedItemController::class, 'index'])->name('damaged.item.index');
Route::post('barang-kondisi-rusak', [DamagedItemController::class, 'store'])->name('damaged.item.store');
Route::put('barang-kondisi-rusak/{id}', [DamagedItemController::class, 'update'])->name('damaged.item.update');
Route::delete('barang-kondisi-rusak/{id}', [DamagedItemController::class, 'destroy'])->name('damaged.item.destroy');
Route::post('barang-kondisi-rusak/import-class', [DamagedItemController::class, 'import'])->name('damaged.item.import');
