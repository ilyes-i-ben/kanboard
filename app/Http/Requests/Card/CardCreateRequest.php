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
            'assignees' => 'nullable|array',
            'deadline' => 'nullable|date',
            'assignees.*' => 'integer|exists:users,id',
        ];
    }
}
