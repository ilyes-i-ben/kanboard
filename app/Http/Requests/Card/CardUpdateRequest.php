<?php

namespace App\Http\Requests\Card;

class CardUpdateRequest extends CardRequest
{
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:low,medium,high',
            'deadline' => 'nullable|date',
            'assignees' => 'array',
            'assignees.*' => 'exists:users,id',
            'category_id' => 'nullable|integer',
        ];
    }
}
