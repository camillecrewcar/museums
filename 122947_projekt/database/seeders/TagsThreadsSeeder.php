<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tags;
use App\Models\Threads;
use App\Models\TagsThreads;
use Faker\Factory as Faker;

class TagsThreadsSeeder extends Seeder
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
        $threads = Threads::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            $randomTag = $faker->randomElement($tags);
            $randomThread = $faker->randomElement($threads);

            TagsThreads::create([
                'tag_id' => $randomTag,
                'thread_id' => $randomThread,
            ]);
        }
    }
}
