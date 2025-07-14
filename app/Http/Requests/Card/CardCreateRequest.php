<?php

namespace App\Http\Requests\Card;

class CardCreateRequest extends CardRequest
{
    public function rules(): array
    {
        return [
            'board_id' => 'required|integer',
            'list_id' => 'required|integer|exists:lists,id',
            'title' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'description' => 'nullable|string',
            'members' => 'nullable|array',
            'deadline' => 'nullable|date',
            'members.*' => 'integer|exists:users,id',
        ];
    }
}
