<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\BoardController;

Route::prefix('api')->group(function () {
    Route::put('/cards/move', [CardController::class, 'move'])
        ->name('cards.move');

    Route::put('/lists/move', [ListController::class, 'move'])
        ->name('lists.move');

    Route::get('/cards/{card}/modal', [CardController::class, 'modal'])->name('cards.modal');

    Route::get('/cards/{card}/render', [CardController::class, 'render'])->name('cards.render');
    Route::get('/lists/{list}/render', [ListController::class, 'render'])->name('lists.render');


    Route::post('/cards/{card}/update', [CardController::class, 'update'])->name('cards.update.post');
    Route::post('/cards/{card}/mark-incomplete', [CardController::class, 'markIncomplete'])->name('cards.mark-incomplete');

    Route::post('/cards/{card}/share', [CardController::class, 'share'])->name('cards.share');

    Route::get('/boards/{board}/calendar-data', [BoardController::class, 'calendarData'])->name('api.boards.calendar-data');

    Route::apiResource('cards', CardController::class);
    Route::apiResource('lists', ListController::class);
});
