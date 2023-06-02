<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Instagram;
use App\Models\News;
use App\Models\Resource;
use App\Models\Twitter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => "test",
            'email' => "test@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ]);

        $resources = Resource::factory(20)->create();
        foreach ($resources as $resource) {
            News::factory(5)->for($resource)->create();
            Instagram::factory(5)->for($resource)->create();
            Twitter::factory(5)->for($resource)->create();
        }
    }
}
