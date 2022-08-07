<?php

namespace App\Services;

use App\Contracts\SendSubscriberNotificationContract;
use App\Events\SubscriberEvent;
use App\Models\PostUser;
use App\Models\User;
use App\Models\Website;

class SendSubscriberNotificationService implements SendSubscriberNotificationContract
{
    protected $subscribers;

    public function __construct()
    {
        $this->subscribers = $this->setSubscribers();
    }

    public function setSubscribers()
    {
        $subscribers = User::with(['websites.posts'])->get();

        foreach($subscribers as $subscriber)
        {
            foreach($subscriber->websites as $website)
            {
                $notificationSentPosts = PostUser::select('post_id')
                    ->where('user_id', $subscriber->id)
                    ->pluck('id')
                    ->toArray();
                $posts = $website->posts;
                $posts = $posts->whereNotIn('id', $notificationSentPosts);
                $website->posts = $posts;
            }
        }

        return $subscribers;
    }

    public function getSubscribers()
    {
        return $this->subscribers;
    }

    public function sendNotification()
    {
       
    }

}
