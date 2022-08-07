<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Notifications\PostPublishedNotification;
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
        $subscribers = User::with('websites.posts')->get();

        foreach($subscribers as $subscriber)
        {
            foreach($subscriber->websites as $website)
            {
                foreach($website->posts as $post)
                {
                    $subscriber->notify(new PostPublishedNotification($post));
                }
            }
        }
    }
}
