<?php

namespace App\Policies;

use App\Models\ListModel;
use App\Models\User;

class ListModelPolicy
{
    public function delete(User $user, ListModel $list): bool
    {
        return
            $list->created_by === $user->id
            || $list->board?->created_by === $user->id;
    }
}
