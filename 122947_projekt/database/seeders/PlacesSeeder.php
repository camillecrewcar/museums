<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Places;
use App\Models\Coordinates;
use Faker\Factory as Faker;
use Stringable;
use Illuminate\Support\Str;


class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $museumsData = [
            [
                'name' => 'Wieliczka Salt Mine',
                'latitude' => 49.9834,
                'longitude' => 20.0523,
            ],
            [
                'name' => 'Auschwitz-Birkenau State Museum',
                'latitude' => 50.0349,
                'longitude' => 19.1796,
            ],
            [
                'name' => 'Wawel Castle',
                'latitude' => 50.0547,
                'longitude' => 19.9354,
            ],
            [
                'name' => 'Old Town Market Square, Kraków',
                'latitude' => 50.0614,
                'longitude' => 19.9371,
            ],
            [
                'name' => 'Malbork Castle',
                'latitude' => 54.0391,
                'longitude' => 19.0267,
            ],
            [
                'name' => 'Białowieża Forest',
                'latitude' => 52.6920,
                'longitude' => 23.8577,
            ],
            [
                'name' => 'Wrocław Market Square',
                'latitude' => 51.1107,
                'longitude' => 17.0326,

            ],
        ];

        foreach ($museumsData as $museumData) {
            $coordinates = Coordinates::create([
                'latitude' => $museumData['latitude'],
                'longitude' => $museumData['longitude'],
            ]);

            Places::create([
                'name' => $museumData['name'],
                'description' => $faker->text(500),
                'coordinates_id' => $coordinates->id,
                'code' => Str::random(6),
                'verified' => 0
            ]);
        }
    }
}
