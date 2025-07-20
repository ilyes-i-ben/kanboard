<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        $pendingInvitations = $notifiable->pendingInvitations()->get();

        return (new MailMessage)
            ->subject("Welcome to Kanboard! 🎉")
            ->markdown('emails.welcome', [
                'name' => $notifiable->name,
                'pendingInvitations' => $pendingInvitations ?? [],
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
