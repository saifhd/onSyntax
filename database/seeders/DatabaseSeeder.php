<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        $website = Website::factory()->create();
        $post1 = Post::factory()->create([
            'website_id' => $website->id
        ]);
        $post2 = Post::factory()->create([
            'website_id' => $website->id
        ]);


        $website->subscribers()->attach($user->id);
    }
}
