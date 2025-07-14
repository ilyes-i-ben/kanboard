<?php

use App\Http\Controllers\Api\CardController;

Route::prefix('api')->group(function () {
    Route::put('/cards/move', [CardController::class, 'move'])
        ->name('cards.move');

    Route::get('/cards/{card}/render', [CardController::class, 'render'])->name('cards.render');

    Route::apiResource('cards', CardController::class);
});
