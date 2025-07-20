<?php

namespace App\Listeners;

use App\Models\Invitation;
use App\Models\User;
use App\Notifications\BoardInvitationNotification;
use Illuminate\Auth\Events\Verified;

class SendDeferredBoardInvitations
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
//
//    /**
//     * Handle the event.
//     */
//    public function handle(Verified $event): void
//    {
//        /** @var User $user */
//        $user = $event->user;
//
//        $deferredInvitations = Invitation::valid()
//            ->where('email', $user->email)
//            ->where('waiting_user_registration', true)
//            ->get();
//
//        foreach ($deferredInvitations as $invitation) {
//            $user->notify(new BoardInvitationNotification($invitation->board, $invitation));
//        }
//        // todo: side effects of changing the invitation.
//    }
}
