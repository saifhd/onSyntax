<?php

namespace App\Listeners;

use App\Events\SubscriberPostEvent;
use App\Models\PostUser;
use App\Notifications\PostPublishedNotification;

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
