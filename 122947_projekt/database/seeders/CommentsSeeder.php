<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comments;
use App\Models\Threads;
use App\Models\User;
use Faker\Factory as Faker;

class CommentsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $threads = Threads::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $comment = Comments::create([
                'thread_id' => $faker->randomElement($threads),
                'description' => $faker->paragraph,
                'user_id' => $faker->randomElement($users),
            ]);
        }
    }
}
