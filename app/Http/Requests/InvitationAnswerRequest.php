<?php

namespace App\Http\Requests;

use App\Models\Invitation;
use Illuminate\Foundation\Http\FormRequest;

class InvitationAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Invitation $invitation */
        $invitation = $this->route('invitation');

        return $invitation->isValid() && $invitation->email === auth()->user()->email;
    }
}
