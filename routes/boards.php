<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\BoardInvitationController;
use App\Http\Controllers\BoardMemberController;
use App\Http\Controllers\InvitationResponseController;

Route::middleware(['auth', 'verified', 'throttle:100,1'])->group(function () {
    Route::prefix('boards/{board}/members')->name('boards.members.')->group(function () {
        Route::get('/', [BoardMemberController::class, 'index'])->name('index');
        Route::delete('{user}', [BoardMemberController::class, 'remove'])->name('remove');
    });

    Route::prefix('boards/{board}/invitations')->name('boards.invitations.')->group(function () {
        Route::post('/', [BoardInvitationController::class, 'store'])->name('store');
    });

    Route::prefix('invitations')->group(function () {
        Route::post('{invitation}/accept', [InvitationResponseController::class, 'accept'])->name('boards.invitations.accept');
        Route::post('{invitation}/decline', [InvitationResponseController::class, 'decline'])->name('boards.invitations.decline');
    });

    Route::prefix('api/boards')->name('boards.api.')->group(function () {
        Route::patch('{board}/update-title', [BoardController::class, 'rename'])->name('update-title');
    });

    Route::resource('/boards', BoardController::class)
        ->except('create');
});
