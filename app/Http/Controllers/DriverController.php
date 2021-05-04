<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
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
            'name' => $request->data['name'],
            'last_name'=> $request->data['last_name'] ?? null,
            'license_no' => $request->data['license_no'] ?? null,
            'license_expiry_date' => $request->data['license_expiry_date'] ?? null,
            'mobile_no' => $request->data['mobile_no'] ?? null,
            'NIN' => $request->data['NIN'],
            'branch_no' => $request->data['branch_no'] ?? null,
            'province' => $request->data['province'] ?? null
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
            'name' => $request->data['name'],
            'last_name'=> $request->data['last_name'] ?? null,
            'license_no' => $request->data['license_no'] ?? null,
            'license_expiry_date' => $request->data['license_expiry_date'] ?? null,
            'mobile_no' => $request->data['mobile_no'] ?? null,
            'NIN' => $request->data['NIN'],
            'branch_no' => $request->data['branch_no'] ?? null,
            'province' => $request->data['province'] ?? null
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
