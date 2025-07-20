<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmailNotification implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify your Kanboard account.')
            ->markdown('emails.verify-email', [
                'url' => $this->verificationUrl($notifiable),
                'name' => $notifiable->name,
            ]);
    }
}
