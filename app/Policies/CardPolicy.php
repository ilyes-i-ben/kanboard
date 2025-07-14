<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;

class CardPolicy
{
    public function delete(User $user, Card $card): bool
    {
        return
            $card->created_by === $user->id
            || $card->list?->board?->created_by === $user->id;
    }
}
