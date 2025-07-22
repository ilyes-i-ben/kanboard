<?php

namespace Database\Seeders\Handlers;

use App\Models\ListModel;

class ListHandler
{
    public static function createLists($board, $listsData, $creator, $boardMembers, $categories): void
    {
        foreach ($listsData as $listIndex => $listData) {
            $list = ListModel::create([
                'board_id' => $board->id,
                'title' => $listData['title'],
                'position' => $listIndex * 1000,
                'is_terminal' => $listData['is_terminal'],
                'created_by' => $creator->id,
                'created_at' => fake()->dateTimeBetween($board->created_at, '-1 week'),
                'updated_at' => now(),
            ]);

            CardHandler::createCards($list, $listData, $boardMembers, $categories);
        }
    }

    public static function createPersonalLists($board, $admin, $categories): void
    {
        $personalLists = [
            ['title' => 'Today', 'cards' => 5, 'is_terminal' => false],
            ['title' => 'This Week', 'cards' => 8, 'is_terminal' => false],
            ['title' => 'Someday', 'cards' => 12, 'is_terminal' => false],
            ['title' => 'Completed', 'cards' => 25, 'is_terminal' => true],
        ];

        foreach ($personalLists as $listIndex => $listData) {
            $list = ListModel::create([
                'board_id' => $board->id,
                'title' => $listData['title'],
                'position' => $listIndex * 1000,
                'is_terminal' => $listData['is_terminal'],
                'created_by' => $admin->id,
                'created_at' => fake()->dateTimeBetween($board->created_at, '-1 week'),
                'updated_at' => now(),
            ]);

            CardHandler::createPersonalCards($list, $listData['cards'], $categories, $admin, $listData['is_terminal']);
        }
    }
}
