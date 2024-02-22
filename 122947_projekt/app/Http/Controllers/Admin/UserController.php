<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Places;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $tag = Tags::all();
        $cities = Cities::all();
        return view('admin.users.index', compact('users', 'tag', 'cities'));
    }
    // public function edit(User $user)
    // {

    // }

    // public function update(Request $request, User $user)
    // {
    //     // Validate the user input
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         // Add any additional fields you want to validate
    //     ]);

    //     // Update the user with the validated data
    //     $user->update($validatedData);

    //     // Redirect back to the user list or show success message
    //     return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the input fields
        $user->update($request->only([
            'name',
            'email',
            'surname',
            'login',
            'role',
        ]));


        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function toggleVerification(Request $request, $id)
    {
        $place = Places::findOrFail($id);

        // Toggle the "verified" field
        $place->verified = ($place->verified === 1) ? 0 : 1;
        $place->save();

        return redirect()->back()->with('success', 'Verification status updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

}
