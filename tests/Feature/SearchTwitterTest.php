<?php

namespace Tests\Feature;

use App\Models\Twitter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTwitterTest extends TestCase
{
    public function test_validation_with_empty_request(): void
    {
        $response = $this->get('/api/twitter/search');

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The start date field is required when none of content / resource / user are present.",
            "The content field is required when none of start date / resource / user are present.",
            "The resource field is required when none of start date / content / user are present.",
            "The user field is required when none of start date / content / resource are present."
        ]]);
    }

    public function test_validation_with_large_values()
    {
        $response = $this->get('/api/twitter/search?' . http_build_query([
            "content" => "w",
            "user" => "t",
            "resource" => "t"
        ]));

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The content field must be at least 2 characters.",
            "The resource field must be at least 2 characters.",
            "The user field must be at least 2 characters."
        ]]);
    }

    public function test_validation_small_values()
    {
        $response = $this->get('/api/twitter/search?' . http_build_query([
            "content" => str_repeat("test", 71),
            "user" => str_repeat("test", 71)
        ]));

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The content field must not be greater than 70 characters.",
            "The user field must not be greater than 50 characters.",
        ]]);
    }

    public function test_date_format()
    {
        $response = $this->get('/api/twitter/search?' . http_build_query([
            "start_date" => "2023-01-01 10:11:12",
            "end_date" => "2023-01-01 10:11:12",
        ]));

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The start date field must match the format Y-m-d.",
            "The end date field must match the format Y-m-d."
        ]]);
    }

    public function test_search_twitter()
    {
        $sampleTwitter = Twitter::find(100);

        if (empty($sampleTwitter)) {
            throw new \Exception("Run the db:seed command first.");
        }

        $words = explode(" ", $sampleTwitter->content);
        $firstThreeWords = array_slice($words, 0, 3);

        $response = $this->get('/api/twitter/search?' . http_build_query([
            "content" => implode(" ", $firstThreeWords),
            "resource" => $sampleTwitter->resource->name,
            "start_date" => $sampleTwitter->created_at->format("Y-m-d"),
        ]));

        $response->assertStatus(200);

        $response->assertJsonPath("data.0.content", $sampleTwitter->content);
        $response->assertJsonPath("data.0.resource_id", $sampleTwitter->resource->id);
    }
}
