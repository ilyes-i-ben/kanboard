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

        $invitee = User::where('email', $email)->first();

        if ($invitee && $board->members()->where('user_id', $invitee->id)->exists()) {
            return back()->withErrors(['invitation_sent' => 'Already member.'])->withInput();
        }

        $validInvitation = Invitation::query()
            ->where('board_id', $board->id)
            ->where('email', $email)
            ->valid()
            ->first();

        if (!empty($validInvitation)) {
            return back()->withErrors(['invitation_sent' => 'Already invited.'])->withInput();
        }

        // TODO: custom expiration time.
        $invitation = Invitation::create([
            'board_id' => $board->id,
            'email' => $email,
            'token' => Str::uuid(),
            'inviter_id' => auth()->id(),
            'expires_at' => now()->addDays(7),
        ]);

        if ($invitee) {
            $invitee->notify(new BoardInvitationNotification($board, $invitation));
        } else {
            $invitation->update(['waiting_user_registration' => true]);
            Notification::route('mail', $email)->notify(new BoardInvitationNotification($board, $invitation));
        }

        return back()->with(['invitation_sent' => 'Invitation sent !'])->withInput();
    }
}
