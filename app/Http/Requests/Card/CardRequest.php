<?php

namespace App\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;

abstract class CardRequest extends FormRequest
{
    public function authorize(): bool
    {
        $boardId = $this->input('board_id');
        return auth()->user() && auth()->user()->boards()->where('id', $boardId)->exists();
    }
}
