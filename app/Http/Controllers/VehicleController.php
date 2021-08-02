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
            'vehicle_no' => $request->vehicle_no,
            'model'=> $request->model ?? null,
            'color' => $request->color,
            'chassis_no' => $request->chassis_no ?? null,
            'plate' => $request->plate ?? null,
            'type' => $request->type ?? null,
            'branch_no' => $request->branch_no ?? null,
            'province' => $request->province ?? null,
            //'driver_id' => $request->driver_id ?? null
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
       //return $request;
        $vehicle->update([
            'vehicle_no' => $request->vehicle_no,
            'model'=> $request->model,
            'color' => $request->color,
            'chassis_no' => $request->chassis_no,
            'plate' => $request->plate,
            'type' => $request->type,
            'branch_no' => $request->branch_no,
            'province' => $request->province,
            //'driver_id' => $request->driver_id
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
