<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Resource;
use App\Mail\ResourceAlarmEmail;
use Illuminate\Support\Facades\Mail;

class CreateTwitterTest extends TestCase
{
    public function test_create_twitter_and_send_email_to_subscribers()
    {
        Mail::fake();

        $resourceId = 1;

        $twitterData = [
            "resource_id" => $resourceId,
            "user_name" => "mamd",
            "content" => "this is the content of the tweet",
            "retweet_count" => 4,
            "image" => "https://something.com/something",
            "user_avatar" => "https://something.com/something",
        ];

        $this->get('/api/resource/1/subscribe');

        $response = $this->post('/api/twitter', $twitterData);
        $response->assertStatus(200);
        $response->assertJson(["message" => "Tweet created successfully."]);

        $this->assertDatabaseHas("twitters", $twitterData);

        $users = Resource::find($resourceId)->subscribers;
        Mail::assertQueued(ResourceAlarmEmail::class, function ($mail) use ($users) {
            return $mail->hasTo($users->pluck('email'));
        });
    }
}
