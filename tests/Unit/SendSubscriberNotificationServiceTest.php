<?php

namespace Tests\Unit;

use App\Contracts\SendSubscriberNotificationContract;
use App\Events\SubscriberPostEvent;
use App\Listeners\SubscriberPostNotificationListener;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\User;
use App\Models\Website;
use App\Notifications\PostPublishedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\CreatesApplication;
use Tests\TestCase;

class SendSubscriberNotificationServiceTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     @test
     */
    public function it_can_get_all_users_with_pending_posts()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();
        $post1 = Post::factory()->create([
            'website_id' => $website->id
        ]);
        $post2 = Post::factory()->create([
            'website_id' => $website->id
        ]);

        PostUser::create([
            'post_id' => $post1->id,
            'user_id' => $user->id
        ]);

        $website->subscribers()->attach($user->id);
        $contract = app(SendSubscriberNotificationContract::class);

        $this->assertEquals(1,$contract->getSubscribers()->count());

        $userPostsCount = $contract->getSubscribers()->first()->websites->first()->posts->count();

        $this->assertEquals(1, $userPostsCount);

    }

    /**
     @test
     */
    public function it_can_send_notification_to_user_who_subscribe_the_website()
    {
        $userTest = User::factory()->create();
        $user = User::factory()->create();
        $website = Website::factory()->create();
        $post = Post::factory()->create([
            'website_id' => $website->id
        ]);
        $website->subscribers()->attach($user->id);

        Notification::fake();
        $contract = app(SendSubscriberNotificationContract::class);
        $contract->sendNotification();

        Notification::assertSentTo($user, PostPublishedNotification::class);
        Notification::assertNothingSentTo($userTest, PostPublishedNotification::class);
    }

    /**
     @test
     */
    public function it_can_dispatches_an_event()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();

        $post1 = Post::factory()->create([
            'website_id' => $website->id
        ]);

        Post::factory()->create([
            'website_id' => $website->id
        ]);

        PostUser::create([
            'post_id' => $post1->id,
            'user_id' => $user->id
        ]);

        $website->subscribers()->attach($user->id);

        Event::fake();
        $contract = app(SendSubscriberNotificationContract::class);
        $contract->sendNotification();

        Event::assertDispatched(SubscriberPostEvent::class);
        Event::assertListening(SubscriberPostEvent::class, SubscriberPostNotificationListener::class);

    }

    /**
     @test
     */
    public function it_can_send_notification_to_user_one_time_for_each_post()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();

        $post1 = Post::factory()->create([
            'website_id' => $website->id
        ]);

        Post::factory()->create([
            'website_id' => $website->id
        ]);

        PostUser::create([
            'post_id' => $post1->id,
            'user_id' => $user->id
        ]);

        $website->subscribers()->attach($user->id);

        Notification::fake();
        $contract = app(SendSubscriberNotificationContract::class);
        $contract->sendNotification();

        Notification::assertSentTo($user, PostPublishedNotification::class);
        Notification::assertCount(1);

    }

    /**
     @test
     */
    public function it_can_updates_post_users_table_if_notification_sent()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();

        $post = Post::factory()->create([
            'website_id' => $website->id
        ]);


        $website->subscribers()->attach($user->id);

        Notification::fake();
        $contract = app(SendSubscriberNotificationContract::class);
        $contract->sendNotification();

        $this->assertDatabaseHas('post_users',[
            'post_id' => $post->id,
            'user_id' => $user->id
        ]);

        Notification::assertSentTo($user, PostPublishedNotification::class);
        Notification::assertCount(1);

    }

}
