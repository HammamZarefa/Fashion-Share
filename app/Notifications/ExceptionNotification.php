<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ExceptionNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $line;
    protected $file;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $line, $file)
    {
        $this->message = $message;
        $this->line = $line;
        $this->file = $file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.chat_id'))
            ->content("*" . "Fashion Share Exception"
                . "*\n\n" . "Exception Message:  " . "*" . $this->message
                . "*\n\n" . "Exception line:  " . "*" . $this->line
                . "*\n\n" . "Exception file:  " . "*" . $this->file
                . "*\n"
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
