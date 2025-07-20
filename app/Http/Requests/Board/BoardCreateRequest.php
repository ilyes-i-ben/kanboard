<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

class BoardCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // all users can create boards..
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:4'],
            'description' => [],
            'background_color' => [],
            'categories' => ['array', 'nullable'],
            'categories.*' => ['string', 'nullable', 'max:255'],
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
