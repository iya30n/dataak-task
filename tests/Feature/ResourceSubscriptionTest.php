<?php

namespace Tests\Feature;

use App\Models\Resource;
use Tests\TestCase;

class ResourceSubscriptionTest extends TestCase
{
    public function test_user_subscribes_to_a_resource()
    {
        $resource = Resource::query()->firstOrCreate(['name' => 'test'], ['name' => 'test']);
        
        $response = $this->get('/api/resource/' . $resource->id . '/subscribe');
        $response->assertJson(["message" => sprintf("you have been subscribed to the %s resource.", $resource->name)]);
        
        $response = $this->get('/api/resource/' . $resource->id . '/subscribe');
        $response->assertJson(["message" => "you've already subscribed."]);

        $this->assertDatabaseHas('user_resources', ['user_id' => 1, 'resource_id' => $resource->id]);

        $resource->subscribers()->detach(1);
    }

    public function test_user_subscription_limit()
    {
        $resources = Resource::limit(10)->get();

        foreach($resources as $resource) {
            $this->get('/api/resource/' . $resource->id . '/subscribe');
        }

        $response = $this->get('/api/resource/11/subscribe');
        $response->assertStatus(403);
        $response->assertJson(["message" => "Sorry, you can't subscribe on more than 10 resources."]);
    }
}
