<?php

namespace App\Services;

use App\Models\Card;
use App\Models\ListModel;

class CardService
{
    public function move(Card $card, ListModel $targetList, int $targetPosition): void
    {
        $cards = $targetList->cards()->orderBy('position')->get()->values();

        if ($cards->isEmpty()) {
            $newPosition = 1000.0;
        } elseif ($targetPosition <= 0) {
            $newPosition = $cards[0]->position / 2;
        } elseif ($targetPosition >= $cards->count()) {
            $newPosition = $cards->last()->position + 1000.0;
        } else {
            $prev = $cards[$targetPosition - 1]->position;
            $next = $cards[$targetPosition]->position;
            $newPosition = ($prev + $next) / 2;
        }

        $card->update([
            'list_id' => $targetList->id,
            'position' => $newPosition,
        ]);
    }

    public function nextPosition(ListModel $list): float
    {
        $max = $list->cards()->max('position') ?? 0;
        return $max + 1000.0;
    }
}
