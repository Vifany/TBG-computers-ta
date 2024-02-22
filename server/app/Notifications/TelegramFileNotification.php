<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use NotificationChannels\Telegram\TelegramFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;

class TelegramFileNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $path,
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram()
    {
        return TelegramFile::create()
            ->file(Storage::disk('public')->path($this->path), 'document');
    }

}
