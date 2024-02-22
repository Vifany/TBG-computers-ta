<?php

namespace App\Console\Commands;

use App\Jobs\EmailSendJob;
use App\Models\Recipient;
use Illuminate\Console\Command;

class AddJobTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't:j';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Recipient::all() as $r) {
            EmailSendJob::dispatch($r);
        }
    }
}
