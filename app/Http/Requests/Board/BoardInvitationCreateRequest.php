<?php

namespace App\Http\Requests\Board;

class BoardInvitationCreateRequest extends OwnsBoardRequest
{
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
