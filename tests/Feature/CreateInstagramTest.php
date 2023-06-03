<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Resource;
use App\Mail\ResourceAlarmEmail;
use Illuminate\Support\Facades\Mail;

class CreateInstagramTest extends TestCase
{
    public function test_create_instagram_and_send_email_to_subscribers()
    {
        Mail::fake();

        $resourceId = 1;

        $instagramData = [
            "title" => "test 1",
            "resource_id" => $resourceId,
            "user_name" => "mamd",
            "user_username" => "mamd21",
            "user_avatar" => "https://something.com/something",
            "content" => "this is the content of instagram post",
            "images_gallery" => [],
            "video_gallery" => [],
        ];

        $response = $this->post('/api/instagram', $instagramData);

        $response->assertStatus(200);
        $response->assertJson(["message" => "Instagram post created successfully."]);

        $this->assertDatabaseHas("instagrams", $instagramData);

        $users = Resource::find($resourceId)->subscribers;
        Mail::assertQueued(ResourceAlarmEmail::class, function ($mail) use ($users) {
            return $mail->hasTo($users->pluck('email'));
        });
    }
}
