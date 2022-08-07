<?php

namespace Tests\Feature;

use App\Jobs\SubscriberNotificationJob;
use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Notifications\PostPublishedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendNotificationToUsersCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     @test
     */
    public function it_can_send_notifications_to_user()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();
        Post::factory()->create([
            'website_id' => $website->id
        ]);

        $website->subscribers()->attach($user->id);

        Notification::fake();

        Artisan::call('send:post-notification');

        Notification::assertSentTo($user, PostPublishedNotification::class);
    }

    /**
     @test
     */
    public function it_can_dispatches_a_queued_job()
    {
        Queue::fake();

        Artisan::call('send:post-notification');

        Queue::assertPushed(SubscriberNotificationJob::class);
    }

}
