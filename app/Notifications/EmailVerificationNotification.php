<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $token
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = config('app.frontend_url') . '/verify-email?token=' . $this->token;

        return (new MailMessage)
            ->subject('Verify Your Email - DataSyncHub')
            ->greeting('Welcome to DataSyncHub, ' . $notifiable->name . '!')
            ->line('Thank you for registering. Please verify your email address to complete your registration.')
            ->action('Verify Email', $url)
            ->line('This link will expire in 24 hours.')
            ->line('If you did not create an account, no further action is required.');
    }
}
