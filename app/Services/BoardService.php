<?php

namespace App\Services;

use App\Models\Board;

class BoardService
{
    public function keepIds(Board $board, array $categoryIds, array $categoryNames): array
    {
        $categoriesToSync = collect($categoryNames)
            ->map(function($name, $index) use ($categoryIds) {
                return [
                    'id' => $categoryIds[$index] ?? null,
                    'name' => trim($name)
                ];
            })
            ->filter(function($category) {
                return !empty($category['name']);
            });

        $existingCategories = $board->categories()->get()->keyBy('id');

        $keepIds = [];

        foreach ($categoriesToSync as $categoryData) {
            if ($categoryData['id'] && $existingCategories->has($categoryData['id'])) {
                $existingCategories[$categoryData['id']]->update(['name' => $categoryData['name']]);
                $keepIds[] = $categoryData['id'];
            } else {
                $newCategory = $board->categories()->create(['name' => $categoryData['name']]);
                $keepIds[] = $newCategory->id;
            }
        }

        return $keepIds;
    }

    public function createCategories(Board $board, array $categories): void
    {
        foreach ($categories as $catName) {
            if ($catName && trim($catName) !== '') {
                $board->categories()->create(['name' => trim($catName)]);
            }
        }
    }
}
