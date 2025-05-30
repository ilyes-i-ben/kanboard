<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\BoardInvitationController;
use App\Http\Controllers\BoardMemberController;


Route::prefix('boards/{board}/members')->name('boards.members.')->group(function () {
    Route::get('/', [BoardMemberController::class, 'index'])->name('index');
    Route::post('/', [BoardMemberController::class, 'add'])->name('add');
    Route::delete('{user}', [BoardMemberController::class, 'remove'])->name('remove');
});

Route::prefix('boards/{board}/invitations')->name('boards.invitations.')->group(function () {
    Route::get('/', [BoardInvitationController::class, 'index'])->name('index');
    Route::post('/', [BoardInvitationController::class, 'store'])->name('store');
    Route::delete('{invitation}', [BoardInvitationController::class, 'destroy'])->name('destroy');
});

Route::resource('/boards', BoardController::class)->except('create');
