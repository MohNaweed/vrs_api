<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function index()
    {
        return Location::orderBy('address','desc')->get();
    }

    public function store(Request $request)
    {
        return Location::create([
            'address' => $request->address,
            'longitude'=> $request->longitude ?? null,
            'latitude'=> $request->latitude ?? null,
            'location_info'=> $request->location_info ?? null
        ]);
    }


    public function show(Location $location)
    {
        return $location;
    }

    public function update(Request $request, Location $location)
    {
        $location->update([
            'address' => $request->address,
            'longitude'=> $request->longitude ?? null,
            'latitude'=> $request->latitude ?? null,
            'location_info'=> $request->location_info ?? null
        ]);

        return $location;
    }

    public function destroy(Location $location)
    {
        Location::destroy($location->id);
        return $location;
    }
}
