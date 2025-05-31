<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\BoardInvitationCreateRequest;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\BoardInvitationNotification;
use Illuminate\Support\Facades\Notification;
use Str;

class BoardInvitationController extends Controller
{
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

        if ($invitee) {
            $invitee->notify(new BoardInvitationNotification($board, $invitation));
        } else {
            $invitation->update(['waiting_user_registration' => true]);
            Notification::route('mail', $email)->notify(new BoardInvitationNotification($board, $invitation));
        }

        return back()->with(['invitation_sent' => 'Invitation sent !'])->withInput();
    }
}
