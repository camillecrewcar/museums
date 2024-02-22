<?php

namespace Database\Seeders;

use App\Models\Opinions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Places;
use App\Models\User;

class OpinionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::pluck('id')->toArray();
        $places = Places::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $score = $faker->numberBetween(1, 5);

            $review = Opinions::create([
                'user_id' => $faker->randomElement($users),
                'place_id' => $faker->randomElement($places),
                'score' => $score,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
