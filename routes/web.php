<?php

use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get('identitas-sekolah', [SchoolController::class, 'index'])->name('school.index');
Route::put('identitas-sekolah', [SchoolController::class, 'update'])->name('school.update');
