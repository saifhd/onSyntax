<?php

namespace Tests\Unit;

use App\Contracts\SendSubscriberNotificationContract;
use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Services\SendSubscriberNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
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
        $post = Post::factory()->create([
            'website_id' => $website->id
        ]);
        $website->subscribers()->attach($user->id);

        $contract = app(SendSubscriberNotificationContract::class);

        $this->assertEquals(1,$contract->getSubscribers()->count());
    }

    /**
     @test
     */
    public function it_can_send_notification_to_user()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();
        $post = Post::factory()->create([
            'website_id' => $website->id
        ]);
        $website->subscribers()->attach($user->id);

        $contract = app(SendSubscriberNotificationContract::class);

        $contract->sendNotification();
    }

    public function it_can_send_notification_to_user_one_time_for_each_post()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();
        $post = Post::factory()->create([
            'website_id' => $website->id
        ]);
        $website->subscribers()->attach($user->id);

        $contract = app(SendSubscriberNotificationContract::class);
    }

}
