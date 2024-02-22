<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Coordinates;
use App\Models\Images;
use App\Models\Monument_codes;
use App\Models\OpeningHour;
use App\Models\Places;
use App\Models\Opinions;
use App\Models\Tags;
use Illuminate\Auth\Events\Verified;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlacesController extends Controller
{
    public function show(Request $request, $id)
    {
        $place = Places::findOrFail($id);
        $opinions = Opinions::where('place_id', $id)->get();
        $tag = Tags::all();
        $cities = Cities::all();

        // Retrieve the opening hours for the place
        $openingHours = $place->openingHours()->get();

        return view('places.index', compact('place', 'opinions', 'cities', 'tag', 'openingHours'));
    }

    public function index()
    {
        $place = Places::all();


        return view('cities.index', compact('place'));
    }
    public function create()
    {
        $tag = Tags::all();
        $cities = Cities::all();
        if (!Auth::check()) {
            return redirect()->route('root'); // Redirect to the main page if user is not authenticated
        }
        return view('places.create', compact('tag', 'cities' ));
    }

    public function store(Request $request)
    {
        try {
            // Create the coordinates
            $coordinates = Coordinates::create([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);

            // Create the place
            $code = $request->input('monument_code');
            $monumentCode = Monument_codes::where('code', $code)->first();

            $verified = $monumentCode ? 1 : 0;

            $place = Places::create([
                'name' => $request->input('name'),
                'coordinates_id' => $coordinates->id,
                'code' => $code,
                'description' => $request->input('description'),
                'verified' => $verified,
            ]);

            // Process the submitted opening hours
            $submittedOpeningHours = $request->input('opening_hours');

            $daysOfWeek = [
                'monday' => 1,
                'tuesday' => 2,
                'wednesday' => 3,
                'thursday' => 4,
                'friday' => 5,
                'saturday' => 6,
                'sunday' => 7,
            ];

            foreach ($submittedOpeningHours as $day => $hours) {
                $openingTime = $hours['opening_time'];
                $closingTime = $hours['closing_time'];
                $dayOfWeek = $daysOfWeek[$day];

                // Create the opening hours record
                $openingHour = new OpeningHour([
                    'place_id' => $place->id,
                    'day_of_week' => $dayOfWeek,
                    'opening_time' => $openingTime,
                    'closing_time' => $closingTime,
                ]);

                $openingHour->save();
            }

            // Check if a photo was uploaded
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');

                // Store the file in the storage folder
                $imagePath = $image->store('photos', 'public');
                $imageFileName = 'photos/' . basename($imagePath);

                // Create the image record
                $image = new Images([
                    'source_url' => $imageFileName,
                    'places_id' => $place->id,
                ]);

                $image->save();
            }

            // Redirect to a success page or perform any additional actions

            return redirect()->route('places');
        } catch (QueryException $exception) {
            $errorMessage = 'An error occurred while storing the place.';
            if ($exception->getCode() === '23000') {
                $errorMessage = 'A place with the same name already exists.';
            }

            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
    }

}

