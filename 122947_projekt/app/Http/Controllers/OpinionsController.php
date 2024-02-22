<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Opinions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpinionsController extends Controller
{
    public function addOpinion(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'place_id' => 'required|numeric',
            'score' => 'required|numeric|between:1,5',
            'description' => 'required|string',
        ]);

        // Create a new opinion
        $opinion = new Opinions();
        $opinion->place_id = $validatedData['place_id'];
        $opinion->user_id = Auth::id();

        $opinion->score = $validatedData['score'];
        $opinion->description = $validatedData['description'];
        $image = $request['photo'] ?? null;
        // Store the file in thee storage folder
        $imagePath = $request->file('photo')->store('photos','public');
        $imageFileName = 'photos/' . basename($imagePath);
        // Create the image record
        $image = new Images([
            'source_url' => $imageFileName,
            'places_id' => $opinion->place_id,
        ]);

        $image->save();

        // Save the opinion
        $opinion->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'Opinion added successfully.');
    }

    public function destroy(Opinions $opinion)
    {
        // Check if the user is authorized to delete the opinion (e.g., admin role check)

        // Delete the opinion
        $opinion->delete();

        // Redirect or return a response indicating success
        return redirect()->back()->with('success', 'Opinion deleted successfully');
    }
    public function update(Request $request, Opinions $opinion)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'description' => 'required|string',
        ]);

        // Update the opinion with the new description
        $opinion->description = $validatedData['description'];
        $opinion->save();

        // Redirect the user to the place.show route with the place_id parameter
        return redirect()->route('place.show', ['id' => $opinion->place_id])->with('success', 'Opinion updated successfully.');
    }
}
