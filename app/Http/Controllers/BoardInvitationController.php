<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\BoardInvitationCreateRequest;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\BoardInvitationNotification;
use Str;

class BoardInvitationController extends Controller
{
    public function index()
    {
        dd('got it !');
    }

    public function store(BoardInvitationCreateRequest $request, Board $board)
    {
        $email = $request->validated('email');

        $validInvitation = Invitation::query()
            ->where('board_id', $board)
            ->where('email', $email)
            ->valid()
            ->first();

        if (!empty($validInvitation)) {
            return back()->withErrors(['email' => 'Already invited.'])->withInput();
        }

        // TODO: custom expiration time.
        $invitation = Invitation::create([
            'board_id' => $board->id,
            'email' => $email,
            'token' => Str::uuid(),
            'inviter_id' => auth()->id(),
            'expires_at' => now()->addDays(7),
        ]);

        $invitee = User::where('email', $email)->first();

        if (!empty($invitee)) {
           $invitee->notify(new BoardInvitationNotification($board, $invitation));
        } else {
            // TODO: add when user doesn't exist...
           return back()->withErrors(['email' => 'user doesnt exists'])->withInput();
        }

        return back()->with(['invitation_sent' => 'Invitation sent !'])->withInput();
    }
}
