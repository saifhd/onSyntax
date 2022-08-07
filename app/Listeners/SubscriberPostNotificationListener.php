<?php

namespace App\Listeners;

use App\Events\SubscriberPostEvent;
use App\Models\PostUser;
use App\Notifications\PostPublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SubscriberPostNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SubscriberPost  $event
     * @return void
     */
    public function handle(SubscriberPostEvent $event)
    {

        $subscriber = $event->subscriber;
        // dump(count($subscriber->websites));
        foreach($subscriber->websites as $website)
        {
            foreach($website->posts as $post)
            {
                $subscriber->notify(new PostPublishedNotification($post));
                PostUser::create([
                    'post_id' => $post->id,
                    'user_id' => $subscriber->id
                ]);
            }
        };
    }
}
