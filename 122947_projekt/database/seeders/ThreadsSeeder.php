<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Threads;
use App\Models\Tags;
use App\Models\User;
use Faker\Factory as Faker;

class ThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $tags = Tags::pluck('id')->toArray();

        $userIds = User::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $randomUserId = $faker->randomElement($userIds);
            $randomTagId = $faker->randomElement($tags);

            Threads::create([
                'title' => $faker->sentence,
                'description' => $faker->realText($maxNbChars = 2000),
                'user_id' => $randomUserId,
            ]);
        }
    }
}
