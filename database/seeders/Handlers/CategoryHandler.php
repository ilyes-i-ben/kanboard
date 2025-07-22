<?php

namespace Database\Seeders\Handlers;

use App\Models\Category;

class CategoryHandler
{
    public static function createCategories($board, $categoryNames)
    {
        $categories = collect();
        foreach ($categoryNames as $categoryName) {
            $categories->push(Category::create([
                'name' => $categoryName,
                'board_id' => $board->id,
            ]));
        }
        return $categories;
    }

    public static function createPersonalCategories($board)
    {
        $personalCategories = ['Personal', 'Work', 'Learning', 'Health'];
        $personalCategoryModels = collect();

        foreach ($personalCategories as $catName) {
            $personalCategoryModels->push(Category::create([
                'name' => $catName,
                'board_id' => $board->id,
            ]));
        }

        return $personalCategoryModels;
    }
}
