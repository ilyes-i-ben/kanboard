<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Card;
use App\Models\ListModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a main admin user (you)
        $admin = User::create([
            'name' => 'ilyes',
            'email' => 'ilyes@kanboard.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'created_at' => now()->subMonths(6),
            'updated_at' => now(),
        ]);

        $users = User::factory()->count(10)->create();

        // Add the admin to the users collection for easier reference
        $allUsers = $users->push($admin);

        // Create boards with coherent data
        for ($i = 0; $i < 5; $i++) {
            // Each board created by a random user
            $creator = $allUsers->random();

            $overrideBoard = $i === 0 ? [
                'created_by' => $creator->id,
                'title' => 'My First Kanban Project',
            ] : [
                'created_by' => $creator->id,
            ];

            $board = Board::factory()->create($overrideBoard);

            // Make the creator an owner
            DB::table('board_members')->insert([
                'board_id' => $board->id,
                'user_id' => $creator->id,
                'role' => 'owner',
                'created_at' => $board->created_at,
            ]);

            // Add some random members to this board
            $members = $allUsers->except($creator->id)->random(rand(3, 5));

            foreach ($members as $member) {
                $role = fake()->randomElement(['admin', 'member', 'member', 'member']); // More chance of regular members

                DB::table('board_members')->insert([
                    'board_id' => $board->id,
                    'user_id' => $member->id,
                    'role' => $role,
                    'created_at' => fake()->dateTimeBetween($board->created_at, 'now'),
                ]);
            }

            // For each board, create 3-6 lists
            $listTitles = ['Backlog', 'To Do', 'In Progress', 'In Review', 'Done', 'Archived'];
            $listsForBoard = array_slice($listTitles, 0, rand(3, 6));

            foreach ($listsForBoard as $index => $listTitle) {
                $list = ListModel::factory()->create([
                    'board_id' => $board->id,
                    'title' => $listTitle,
                    'position' => $index * 1000, // Ensure ordered positions
                ]);

                // For each list, create 2-10 cards
                $cardCount = $listTitle === 'Done' ? rand(5, 15) : rand(2, 10);

                for ($j = 0; $j < $cardCount; $j++) {
                    // Cards at the end of the workflow are more likely to be finished
                    $finishProbability = match($listTitle) {
                        'Done', 'Archived' => 95,  // 95% finished
                        'In Review' => 30,         // 30% finished
                        'In Progress' => 10,       // 10% finished
                        default => 0,              // 0% finished
                    };

                    // Choose a creator from board members
                    $cardCreator = $members->random();

                    $card = Card::factory()
                        ->state(function (array $attributes) use ($list, $cardCreator, $finishProbability, $j) {
                            return [
                                'list_id' => $list->id,
                                'position' => $j * 1000, // Ensure ordered positions
                                'created_by' => $cardCreator->id,
                                'finished_at' => fake()->boolean($finishProbability) ? fake()->dateTimeBetween('-2 weeks', 'now') : null,
                            ];
                        })
                        ->create();

                    // Add some assignees to this card
                    $assigneeCount = rand(0, 3);
                    if ($assigneeCount > 0) {
                        $assignees = $members->random($assigneeCount);

                        foreach ($assignees as $assignee) {
                            DB::table('card_members')->insert([
                                'card_id' => $card->id,
                                'user_id' => $assignee->id,
                                'created_at' => fake()->dateTimeBetween($card->created_at, 'now'),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }

        // Create one special board for the admin user with a complete workflow
        $personalBoard = Board::factory()->create([
            'created_by' => $admin->id,
            'title' => 'My Personal Project',
            'background_color' => '#4a90e2',
        ]);

        // Add admin as owner
        DB::table('board_members')->insert([
            'board_id' => $personalBoard->id,
            'user_id' => $admin->id,
            'role' => 'owner',
            'created_at' => $personalBoard->created_at,
        ]);

        // Add standard workflow lists
        $workflowLists = [
            ['title' => 'Backlog', 'cards' => 8],
            ['title' => 'To Do', 'cards' => 5],
            ['title' => 'In Progress', 'cards' => 3],
            ['title' => 'Testing', 'cards' => 2],
            ['title' => 'Done', 'cards' => 12],
        ];

        foreach ($workflowLists as $index => $workflowList) {
            $list = ListModel::factory()->create([
                'board_id' => $personalBoard->id,
                'title' => $workflowList['title'],
                'position' => $index * 1000,
            ]);

            // Create cards for this list
            for ($k = 0; $k < $workflowList['cards']; $k++) {
                $cardCreatedAt = fake()->dateTimeBetween('-2 months', '-1 day');

                $card = Card::factory()->create([
                    'list_id' => $list->id,
                    'created_by' => $admin->id,
                    'position' => $k * 1000,
                    'created_at' => $cardCreatedAt,
                    'updated_at' => fake()->dateTimeBetween($cardCreatedAt, 'now'),
                    'finished_at' => $workflowList['title'] === 'Done' ? fake()->dateTimeBetween('-1 week', 'now') : null,
                ]);

                // Maybe add some members to this card
                if (fake()->boolean(60)) { // 60% chance of having members
                    $cardMembers = $users->random(rand(1, 2));
                    foreach ($cardMembers as $member) {
                        DB::table('card_members')->insert([
                            'card_id' => $card->id,
                            'user_id' => $member->id,
                            'created_at' => fake()->dateTimeBetween($card->created_at, 'now'),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
