<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationAnswerRequest;
use App\Models\Invitation;
class InvitationResponseController extends Controller
{
    public function accept(InvitationAnswerRequest $request, Invitation $invitation)
    {
        $board = $invitation->board;

        $board->members()->syncWithoutDetaching([auth()->id()]);
        $invitation->update(['status' => Invitation::STATUS_ACCEPTED]);

        return redirect()->route('boards.index')->with('success', __('Invitation acceptée.'));
    }

    public function decline(InvitationAnswerRequest $request, Invitation $invitation)
    {
        $invitation->update(['status' => Invitation::STATUS_DECLINED]);
        return redirect()->route('boards.index')->with('success', __('Invitation refusée.'));
    }
}

