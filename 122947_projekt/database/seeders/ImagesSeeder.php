<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Images;
use App\Models\Places;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = Places::all();

        $urls = [];

        // Generate 50 random URLs
        for ($i = 1; $i <= 50; $i++) {
            $urls[] = 'https://example.com/image' . $i . '.jpg';
        }

        foreach ($places as $place) {
            $randomUrl = $urls[array_rand($urls)];

            Images::create([
                'source_url' => $randomUrl,
                'places_id' => $place->id,
            ]);
        }
    }
}
