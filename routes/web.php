<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataEncodingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'prevent-back'])->name('dashboard');

Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Data Encoding Routes
    Route::get('/data-encoding', [DataEncodingController::class, 'index'])->name('data-encoding');
    Route::post('/data-encoding/encode', [DataEncodingController::class, 'store'])->name('data-encoding.encode');
    Route::post('/data-encoding/decode', [DataEncodingController::class, 'decode'])->name('data-encoding.decode');
});

require __DIR__.'/auth.php';
