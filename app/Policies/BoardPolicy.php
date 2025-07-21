<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;

class BoardPolicy
{
    public function update(User $user, Board $board): bool
    {
        return
            $board->created_by === $user->id;
    }

    public function see(User $user, Board $board): bool
    {
        return
            $board->members->contains($user);
    }
}
