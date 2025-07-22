<?php

namespace Database\Seeders\Handlers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BoardMemberHandler
{
    public static function addMembers($board, $creator, $allUsers)
    {
        $boardMembers = $allUsers->except($creator->id)->random(rand(4, 7));

        foreach ($boardMembers as $member) {
            DB::table('board_members')->insert([
                'board_id' => $board->id,
                'user_id' => $member->id,
                'created_at' => fake()->dateTimeBetween($board->created_at, 'now'),
            ]);
        }

        return $boardMembers->push($creator);
    }

    public static function ensureCreatorsAreMember(): void
    {
        foreach (Board::all() as $board) {
            $board->members()->syncWithoutDetaching([$board->created_by]);
        }
    }
}
