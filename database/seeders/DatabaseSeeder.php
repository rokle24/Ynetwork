<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
        ]);
        // get user with id1
        $user = User::find(1);
        $user->posts()->createMany([
            ['title' => 'Post 1',
            'body' => 'This is the first test post.'],
            ['title' => 'Post 2',
            'body' => 'This is the second test post.'],
        ]);
    }
}
