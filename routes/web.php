<?php

use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StafController;
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
