<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Likes;
use App\Models\User;
use App\Models\Comments;
use Faker\Factory as Faker;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::pluck('id')->toArray();
        $comments = Comments::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $isPositive = $faker->randomElement([true, false]);

            $like = Likes::create([
                'user_id' => $faker->randomElement($users),
                'comment_id' => $faker->randomElement($comments),
                'isPositive' => $isPositive,
            ]);
        }
    }
}
