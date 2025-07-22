<?php

namespace Database\Seeders\Handlers;

use App\Models\Card;
use Database\Seeders\CardTitleGenerator;
use Illuminate\Support\Facades\DB;

class CardHandler
{
    public static function createCards($list, $listData, $boardMembers, $categories): void
    {
        $cardCount = match($listData['title']) {
            'Backlog', 'Feature Backlog', 'Ideas & Planning' => rand(8, 15),
            'Completed', 'Released', 'Deployed', 'Active Partnership' => rand(10, 20),
            'Cancelled', 'Declined' => rand(1, 3),
            default => rand(3, 8),
        };

        for ($cardIndex = 0; $cardIndex < $cardCount; $cardIndex++) {
            $isFinished = $listData['is_terminal'] && fake()->boolean(80);
            $category = $categories->random();
            $cardCreator = $boardMembers->random();

            $card = Card::create([
                'list_id' => $list->id,
                'title' => CardTitleGenerator::generate($category->name),
                'description' => fake()->boolean(70) ? fake()->paragraphs(rand(1, 2), true) : null,
                'position' => $cardIndex * 1000,
                'priority' => fake()->randomElement(['low', 'low', 'medium', 'medium', 'medium', 'high']),
                'deadline' => fake()->boolean(60) ? fake()->dateTimeBetween('+1 week', '+3 months') : null,
                'finished_at' => $isFinished ? fake()->dateTimeBetween('-2 weeks', 'now') : null,
                'category_id' => $category->id,
                'public_token' => fake()->boolean(15) ? \Illuminate\Support\Str::random(32) : null,
                'created_by' => $cardCreator->id,
                'created_at' => fake()->dateTimeBetween($list->created_at, 'now'),
                'updated_at' => now(),
            ]);

            self::assignCardMembers($card, $boardMembers);
        }
    }

    public static function createPersonalCards($list, $cardCount, $categories, $admin, $isTerminal): void
    {
        for ($i = 0; $i < $cardCount; $i++) {
            $category = $categories->random();
            $isFinished = $isTerminal && fake()->boolean(90);

            Card::create([
                'list_id' => $list->id,
                'title' => CardTitleGenerator::generatePersonal($category->name),
                'description' => fake()->boolean(50) ? fake()->sentence() : null,
                'position' => $i * 1000,
                'priority' => fake()->randomElement(['low', 'medium', 'medium', 'high']),
                'deadline' => fake()->boolean(40) ? fake()->dateTimeBetween('now', '+1 month') : null,
                'finished_at' => $isFinished ? fake()->dateTimeBetween('-1 week', 'now') : null,
                'category_id' => $category->id,
                'created_by' => $admin->id,
                'created_at' => fake()->dateTimeBetween($list->created_at, 'now'),
                'updated_at' => now(),
            ]);
        }
    }

    private static function assignCardMembers($card, $boardMembers): void
    {
        if (fake()->boolean(70)) {
            $memberCount = rand(1, 3);
            $cardMembers = $boardMembers->random(min($memberCount, $boardMembers->count()));

            $assignedUserIds = collect();
            foreach ($cardMembers as $cardMember) {
                if (!$assignedUserIds->contains($cardMember->id)) {
                    DB::table('card_members')->insert([
                        'card_id' => $card->id,
                        'user_id' => $cardMember->id,
                        'created_at' => fake()->dateTimeBetween($card->created_at, 'now'),
                    ]);
                    $assignedUserIds->push($cardMember->id);
                }
            }
        }
    }
}
