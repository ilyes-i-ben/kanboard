<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\ListController;

Route::prefix('api')->group(function () {
    Route::put('/cards/move', [CardController::class, 'move'])
        ->name('cards.move');

    Route::put('/lists/move', [ListController::class, 'move'])
        ->name('lists.move');

    Route::get('/cards/{card}/render', [CardController::class, 'render'])->name('cards.render');
    Route::get('/lists/{list}/render', [ListController::class, 'render'])->name('lists.render');


    Route::post('/cards/{card}/update', [CardController::class, 'update'])->name('cards.update.post');
    Route::post('/cards/{card}/mark-incomplete', [CardController::class, 'markIncomplete'])->name('cards.mark-incomplete');

    Route::apiResource('cards', CardController::class);
    Route::apiResource('lists', ListController::class);
});
