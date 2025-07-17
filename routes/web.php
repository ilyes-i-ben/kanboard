<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SharedContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::get('/boards', [\App\Http\Controllers\BoardController::class, 'index'])->name('board.index');

// for public cards...

Route::get('/shared-content/card/{token}', [SharedContentController::class, 'showCard'])->name('shared-content.card');

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
require __DIR__.'/boards.php';
