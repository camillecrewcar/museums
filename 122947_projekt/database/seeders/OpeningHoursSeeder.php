<?php

namespace Database\Seeders;

use App\Models\OpeningHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;



class OpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        OpeningHour::truncate();

        $places = DB::table('places')->take(5)->pluck('id');

        $daysOfWeek = range(1, 7); // Numeric representation of days of the week

        foreach ($places as $placeId) {
            for ($i = 0; $i < 3; $i++) {
                $dayOfWeek = $daysOfWeek[$i];
                $openingTime = date('H:i', strtotime("08:00")); // Opening time increments by 1 hour
                $closingTime = date('H:i', strtotime("09:00")); // Closing time increments by 1 hour

                OpeningHour::create([
                    'place_id' => $placeId,
                    'day_of_week' => $dayOfWeek,
                    'opening_time' => $openingTime,
                    'closing_time' => $closingTime,
                ]);
            }
        }
    }
}
