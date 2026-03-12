<?php

namespace Modules\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected string $token;
    protected string $full_name;

    public function __construct(string $token, string $full_name)
    {
        $this->token = $token;
        $this->full_name = $full_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $resetUrl = url('/reset-password/' . $this->token . '?email=' . $notifiable->getEmailForPasswordReset());

        return (new MailMessage())
            ->subject('إعادة تعيين كلمة المرور')
            ->view('auth::Auth.forgot-password', [
                'resetUrl' => $resetUrl,
                'name' => $this->full_name,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
