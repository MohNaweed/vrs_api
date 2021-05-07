<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function login(){
        return 0;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Driver::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Driver::create([
            'name' => $request->name,
            'last_name'=> $request->last_name ?? null,
            'license_no' => $request->license_no ?? null,
            'license_expiry_date' => $request->license_expiry_date ?? null,
            'mobile_no' => $request->mobile_no ?? null,
            'NIN' => $request->NIN,
            'branch_no' => $request->branch_no ?? null,
            'province' => $request->province ?? null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        if($driver != '') return $driver;
        return 'not exist';
        return $driver ?? 'Not Exist';
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        $driver->update([
            'name' => $request->name,
            'last_name'=> $request->last_name ?? null,
            'license_no' => $request->license_no ?? null,
            'license_expiry_date' => $request->license_expiry_date ?? null,
            'mobile_no' => $request->mobile_no ?? null,
            'NIN' => $request->NIN,
            'branch_no' => $request->branch_no ?? null,
            'province' => $request->province ?? null
        ]);

        return $driver;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        return Driver::destroy($driver->id);
    }
}
