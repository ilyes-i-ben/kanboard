<?php

use App\Http\Controllers\Api\CardController;

Route::prefix('api')->group(function () {
    Route::put('/cards/move', [CardController::class, 'move'])
        ->name('cards.move');

    Route::apiResource('cards', CardController::class);
});
