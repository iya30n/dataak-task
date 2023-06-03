<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Resource;
use App\Mail\ResourceAlarmEmail;
use Illuminate\Support\Facades\Mail;

class CreateNewsTest extends TestCase
{
    public function test_create_news_and_send_email_to_subscribers()
    {
        Mail::fake();

        $resourceId = 1;

        $newsData = [
            "title" => "test 1",
            "resource_id" => $resourceId,
            "user_name" => "mamd",
            "content" => "this is the content of news one",
            "link" => "https://something.com/something",
            "agency_avatar" => "https://something.com/something",
        ];

        $this->get('/api/resource/1/subscribe');

        $response = $this->post('/api/news', $newsData);
        $response->assertStatus(200);
        $response->assertJson(["message" => "News created successfully."]);

        $this->assertDatabaseHas("news", $newsData);

        $users = Resource::find($resourceId)->subscribers;
        Mail::assertQueued(ResourceAlarmEmail::class, function($mail) use($users) {
            return $mail->hasTo($users->pluck('email'));
        });
    }
}
