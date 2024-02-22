<?php

namespace Database\Seeders;

 use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\CitiesController;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoordinatesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(ImagesSeeder::class);
        $this->call(PlacesSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(ThreadsSeeder::class);
        $this->call(TagsThreadsSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(LikesSeeder::class);
        $this->call(OpinionsSeeder::class);
        $this->call(OpeningHoursSeeder::class);
        $this->call(monument_codesSeeder::class);



    }
}
