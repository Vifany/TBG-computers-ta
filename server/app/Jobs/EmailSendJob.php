<?php

namespace App\Jobs;

use App\Mail\SendFileMail;
use App\Models\Recipient;
use App\Notifications\TelegramFileNotification;
use App\Types\AddressType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Bus\Batchable;

class EmailSendJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Recipient $recipient,
        protected string $path,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->recipient->address_type == AddressType::EMAIL) {
            Mail::to($this->recipient->address)
                ->send(new SendFileMail($this->path));
        }
        if ($this->recipient->address_type == AddressType::TELEGRAM) {
            Notification::route('telegram', $this->recipient->address)
            ->notify(new TelegramFileNotification($this->path));
        }
    }
}
