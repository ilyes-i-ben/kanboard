<?php

namespace App\Http\Requests\Card;

class CardMoveRequest extends CardRequest
{
    public function rules(): array
    {
        return [
            'board_id' => 'required|integer',
            'card_id' => 'required|integer',
            'list_id' => 'required|integer',
            'position' => 'required|integer',
        ];
    }
}
