<?php

namespace App\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;

class CardMoveRequest extends FormRequest
{
    public function authorize(): bool
    {
        $boardId = $this->input('board_id');
        return auth()->user() && auth()->user()->boards()->where('id', $boardId)->exists();
    }

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
