<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\ListController;

Route::prefix('api')->group(function () {
    Route::put('/cards/move', [CardController::class, 'move'])
        ->name('cards.move');

    Route::get('/cards/{card}/render', [CardController::class, 'render'])->name('cards.render');
    Route::get('/lists/{list}/render', [ListController::class, 'render'])->name('lists.render');

    Route::apiResource('cards', CardController::class);
    Route::apiResource('lists', ListController::class);
});
