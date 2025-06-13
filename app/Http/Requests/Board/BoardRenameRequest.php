<?php

namespace App\Http\Requests\Board;

class BoardRenameRequest extends OwnsBoardRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.min' => 'Le titre du projet est très court.',
            'title.max' => 'Le titre du projet est très long.',
        ];
    }
}
