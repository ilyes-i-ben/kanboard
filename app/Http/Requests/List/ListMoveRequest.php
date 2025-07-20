<?php

namespace App\Http\Requests\List;

class ListMoveRequest extends ListRequest
{
    public function rules(): array
    {
        return [
            'board_id' => 'required|integer',
            'list_id' => 'required|integer',
            'position' => 'required|integer',
        ];
    }
}
