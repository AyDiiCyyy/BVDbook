<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $token;

    public function __construct($token)
    {
        $this->token = $token;

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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Yêu cầu đặt lại mật khẩu')
        ->line('Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
        ->action('Đặt lại mật khẩu', url(route('password.reset', $this->token, false)))
        ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.')
        ->line('Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
