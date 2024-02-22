<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Places;
use App\Models\Tags;
use App\Models\Threads;
use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Illuminate\Console\Command;

class CitiesController extends Controller
{

    public function search(Request $request)
    {
        function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit = 'km')
        {
            $earthRadius = ($unit === 'km') ? 6371 : 3959; // Radius of the earth in either kilometers or miles

            $latDelta = deg2rad($lat2 - $lat1);
            $lonDelta = deg2rad($lon2 - $lon1);

            $a = sin($latDelta / 2) * sin($latDelta / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDelta / 2) * sin($lonDelta / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $distance = $earthRadius * $c;

            return $distance;
        }

        $search = $request->input('search');

        $city = Cities::where('name', $search)->first();

        if (!$city) {
            return redirect()->back()->with('error', 'City not found');
        }

        $cityCoordinates = $city->coordinates;

        $cityLatitude = $cityCoordinates->latitude;
        $cityLongitude = $cityCoordinates->longitude;


        $filteredPlaces = [];
        $places = Places::all();


        foreach ($places as $place) {
            $placeCoordinates = $place->coordinates;
            $placeLatitude = $placeCoordinates->latitude;
            $placeLongitude = $placeCoordinates->longitude;

            $distance = calculateDistance($cityLatitude, $cityLongitude, $placeLatitude, $placeLongitude);
            if ($distance <= 50) {
                $filteredPlaces[] = $place;
            }
        }
        $tag = Tags::all();
        $cities = Cities::all();

        return view('cities.index', compact('filteredPlaces', 'city','tag','cities'));
    }
    public function index()
    {
        $places = Places::all();
        $tag = Tags::all();
        $cities = Cities::all();


        return view('cities.index', compact('places','tag','cities'));
    }



}
