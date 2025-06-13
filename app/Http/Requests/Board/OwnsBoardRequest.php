<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

abstract class OwnsBoardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('board')?->created_by === auth()->id();
    }
}
