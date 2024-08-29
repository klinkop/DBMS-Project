<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\City;


class CityController extends Controller
{
    public function fetchCities(Request $request)
    {
        $stateId = $request->query('state_id');

        if ($stateId) {
            $cities = City::where('state_id', $stateId)->get();
        } else {
            $cities = collect(); // Return an empty collection if no state ID is provided
        }

        return response()->json($cities);
    }
}
