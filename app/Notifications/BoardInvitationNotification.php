<?php

namespace App\Notifications;

use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\AnonymousNotifiable;

class BoardInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Board $board;
    protected Invitation $invitation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Board $board, Invitation $invitation)
    {
        $this->board = $board;
        $this->invitation = $invitation;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $isAnonymous = $notifiable instanceof AnonymousNotifiable;
        $inviter = $this->invitation->inviter;
        $inviterName = $inviter ? $inviter->name : 'Someone';

        return (new MailMessage)
            ->subject("You're invited to join \"{$this->board->title}\" on Kanboard")
            ->markdown('emails.board-invitation', [
                'board' => $this->board,
                'invitation' => $this->invitation,
                'inviterName' => $inviterName,
                'isAnonymous' => $isAnonymous,
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'board_id' => $this->board->id,
            'board_title' => $this->board->title,
            'invitation_id' => $this->invitation->id,
            'invitation_email' => $this->invitation->email,
            'invitation_status' => $this->invitation->status,
            'inviter_id' => $this->invitation->inviter_id,
            'expires_at' => $this->invitation->expires_at,
        ];
    }
}
