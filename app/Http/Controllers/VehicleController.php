<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return Vehicle::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       return Vehicle::create([
            'vehicle_no' => $request->data['vehicle_no'],
            'model'=> $request->data['model'] ?? null,
            'color' => $request->data['color'] ?? null,
            'chassis_no' => $request->data['chassis_no'] ?? null,
            'plate' => $request->data['plate'] ?? null,
            'type' => $request->data['type'],
            'branch_no' => $request->data['branch_no'] ?? null,
            'province' => $request->data['province'] ?? null,
            'driver_id' => $request->data['driver_id']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return $vehicle;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->update([
            'vehicle_no' => $request->data['vehicle_no'],
            'model'=> $request->data['model'] ?? null,
            'color' => $request->data['color'] ?? null,
            'chassis_no' => $request->data['chassis_no'] ?? null,
            'plate' => $request->data['plate'] ?? null,
            'type' => $request->data['type'],
            'branch_no' => $request->data['branch_no'] ?? null,
            'province' => $request->data['province'] ?? null,
            'driver_id' => $request->data['driver_id']
        ]);

        return $vehicle;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        Vehicle::destroy($vehicle->id);
        return $vehicle;
    }
}
