<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\User;
use Database\Seeders\Handlers\BoardMemberHandler;
use Database\Seeders\Handlers\CategoryHandler;
use Database\Seeders\Handlers\ListHandler;
use Database\Seeders\Templates\BoardTemplates;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    public function run(): void
    {
        $allUsers = User::all();
        $admin = User::where('email', 'bilyesc+dev@gmail.com')->first();

        $this->createProjectBoards($allUsers, $admin);
        $this->createPersonalBoard($admin);
        BoardMemberHandler::ensureCreatorsAreMember();
    }

    private function createProjectBoards($allUsers, $admin): void
    {
        $boardTemplates = BoardTemplates::getAll();

        foreach ($boardTemplates as $index => $template) {
            $creator = $index === 0 ? $admin : $allUsers->random();

            $board = $this->createBoard($template, $creator);
            $boardMembers = BoardMemberHandler::addMembers($board, $creator, $allUsers);
            $this->setupBoardContent($board, $template, $creator, $boardMembers);
        }
    }

    private function createPersonalBoard($admin): void
    {
        $personalBoard = new Board([
            'title' => 'Personal Task Management',
            'description' => 'My personal productivity and task tracking board',
            'background_color' => '#1abc9c',
        ]);
        $personalBoard->created_by = $admin->id;
        $personalBoard->created_at = now()->subMonths(2);
        $personalBoard->updated_at = now();
        $personalBoard->save();

        $personalBoard->lists()->delete();

        $categories = CategoryHandler::createPersonalCategories($personalBoard);
        ListHandler::createPersonalLists($personalBoard, $admin, $categories);
    }

    private function createBoard($template, $creator): Board
    {
        $board = new Board([
            'title' => $template['title'],
            'description' => $template['description'],
            'background_color' => $template['color'],
        ]);
        $board->created_by = $creator->id;
        $board->created_at = fake()->dateTimeBetween('-3 months', '-2 weeks');
        $board->updated_at = now();
        $board->save();

        $board->lists()->delete();

        return $board;
    }

    private function setupBoardContent($board, $template, $creator, $boardMembers): void
    {
        $categories = CategoryHandler::createCategories($board, $template['categories']);
        ListHandler::createLists($board, $template['lists'], $creator, $boardMembers, $categories);
    }
}
