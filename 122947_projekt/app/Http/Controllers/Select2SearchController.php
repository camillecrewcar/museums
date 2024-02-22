<?php

namespace App\Http\Controllers;
use App\Models\Cities;
use Illuminate\Http\Request;

class Select2SearchController extends Controller
{

    public function index()
    {
    	return view('welcome');
    }

    public function selectSearch(Request $request)
    {
    	$cities = [];

        if($request->has('q')){
            $search = $request->q;
            $cities =Cities::select("id", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($cities);
    }
}
