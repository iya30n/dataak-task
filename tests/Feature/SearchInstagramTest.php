<?php

namespace Tests\Feature;

use App\Models\Instagram;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchInstagramTest extends TestCase
{
    public function test_validation_with_empty_request(): void
    {
        $response = $this->get('/api/instagram/search');

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The start date field is required when none of title / resource / user are present.",
            "The title field is required when none of start date / resource / user are present.",
            "The resource field is required when none of start date / title / user are present.",
            "The user field is required when none of start date / title / resource are present."
        ]]);
    }

    public function test_validation_with_large_values()
    {
        $response = $this->get('/api/instagram/search?' . http_build_query([
            "title" => "w",
            "user" => "t",
            "resource" => "t"
        ]));

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The title field must be at least 2 characters.",
            "The resource field must be at least 2 characters.",
            "The user field must be at least 2 characters."
        ]]);
    }

    public function test_validation_small_values()
    {
        $response = $this->get('/api/instagram/search?' . http_build_query([
            "title" => str_repeat("test", 71),
            "user" => str_repeat("test", 71)
        ]));

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The title field must not be greater than 70 characters.",
            "The user field must not be greater than 50 characters.",
        ]]);
    }

    public function test_date_format()
    {
        $response = $this->get('/api/instagram/search?' . http_build_query([
            "start_date" => "2023-01-01 10:11:12",
            "end_date" => "2023-01-01 10:11:12",
        ]));

        $response->assertStatus(422);
        $response->assertJson(["errors" => [
            "The start date field must match the format Y-m-d.",
            "The end date field must match the format Y-m-d."
        ]]);
    }

    public function test_search_instagram()
    {
        $sampleInstagram = Instagram::find(100);

        if (empty($sampleInstagram)) {
            throw new \Exception("Run the db:seed command first.");
        }

        $response = $this->get('/api/instagram/search?' . http_build_query([
            "title" => $sampleInstagram->title,
            "resource" => $sampleInstagram->resource,
            "start_date" => $sampleInstagram->created_at->format("Y-m-d"),
        ]));

        $response->assertStatus(200);

        $response->assertJsonPath("data.0.title", $sampleInstagram->title);
        $response->assertJsonPath("data.0.resource", $sampleInstagram->resource);
    }
}
