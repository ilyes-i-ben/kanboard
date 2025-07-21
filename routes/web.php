<?php

use App\Http\Controllers\CardCalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SharedContentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware('throttle:5,1')->group(function () {
    Route::any('/repos/{any}', function () {
        abort(403, 'Access Denied');
    })->where('any', '.*');

    Route::any('/decks/{any}', function () {
        abort(403, 'Access Denied');
    })->where('any', '.*');

    Route::any('/projects/{any}', function () {
        abort(403, 'Access Denied');
    })->where('any', '.*');
});

Route::get('/', function () {
    return view('welcome');
})->middleware('throttle:120,1')->name('welcome-route');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'throttle:120,1'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::get('/boards', [\App\Http\Controllers\BoardController::class, 'index'])->name('board.index');

Route::get('/shared-content/card/{token}', [SharedContentController::class, 'showCard'])
    ->middleware('throttle:30,1')
    ->name('shared-content.card');

Route::get('/boards/{board}/calendar.ics', [CardCalendarController::class, 'boardCalendar'])
    ->middleware(['auth', 'verified', 'throttle:20,1'])
    ->name('board.calendar.ics');

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
require __DIR__.'/boards.php';
