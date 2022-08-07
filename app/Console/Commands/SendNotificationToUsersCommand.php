<?php

namespace App\Console\Commands;

use App\Jobs\SubscriberNotificationJob;
use Illuminate\Console\Command;

class SendNotificationToUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:post-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SubscriberNotificationJob::dispatch();
    }
}
