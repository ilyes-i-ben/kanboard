<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:4'],
            'description' => [],
            'background_color' => [],
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
