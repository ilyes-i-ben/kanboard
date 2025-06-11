<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

class BoardMemberRemoveRequest extends FormRequest
{
    public function authorize(): bool
    {
        $board = $this->route('board');
        return $board->created_by === auth()->id();
    }
}
