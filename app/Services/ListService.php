<?php

namespace App\Services;


use App\Models\Board;
use App\Models\ListModel;

class ListService
{
    public function move(Board $board, ListModel $list, int $newPosition): void
    {
        $lists = $board->lists()->orderBy('position')->get();

        $lists = $lists->filter(fn($l) => $l->id !== $list->id)->values();

        $lists->splice($newPosition, 0, [$list]);

        foreach ($lists as $index => $l) {
            $l->update(['position' => $index]);
        }
    }
}
