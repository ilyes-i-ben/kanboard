<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

class BoardInvitationCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $board = $this->route('board');
        return $board->created_by === auth()->id();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'You must provide an email address.',
            'email.email' => 'That is not a valid email format.',
        ];
    }
}
