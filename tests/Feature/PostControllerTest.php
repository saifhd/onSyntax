<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     @test
     */
     public function it_can_create_a_post()
     {
        // $website = Website::factory()->create();
        // $faker = Faker

        // $response = $this->post('api/v1/posts',[
        //     'title' => "test post",
        //     'description'=> 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        //     'website_id' => $website->id
        // ])->assertCreated();
     }

}
