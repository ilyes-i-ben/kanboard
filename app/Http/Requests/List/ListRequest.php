<?php

namespace App\Http\Requests\List;

use Illuminate\Foundation\Http\FormRequest;

abstract class ListRequest extends FormRequest
{
    public function authorize(): bool
    {
        $boardId = $this->input('board_id');
        return auth()->user() && auth()->user()->boards()->where('id', $boardId)->exists();
    }
}
