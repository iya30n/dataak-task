<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Instagram;
use App\Models\News;
use App\Models\Resource;
use App\Models\Twitter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* News::factory(100)->create();
        Instagram::factory(100)->create();
        Twitter::factory(100)->create(); */

        /* Resource::factory()->count(33)
            ->hasNews(3)
            ->create(); */

        $resources = Resource::factory(20)->create();
        foreach($resources as $resource) {
            News::factory(5)->for($resource)->create();
            Instagram::factory(5)->for($resource)->create();
            Twitter::factory(5)->for($resource)->create();
        }
    }
}
