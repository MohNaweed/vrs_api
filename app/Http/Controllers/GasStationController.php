<?php

namespace App\Http\Controllers;

use App\Models\GasStation;
use Illuminate\Http\Request;

class GasStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GasStation::orderBy('updated_at','desc')->get();
    }


    public function store(Request $request)
    {
        return GasStation::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'contact'=>$request->contact
        ]);
    }


    public function show(GasStation $gasStation)
    {
        return $gasStation;
    }


    public function update(Request $request, GasStation $gasStation)
    {

        return $gasStation->update([
            'name'=> $request->name,
            'address'=> $request->address,
            'contact'=>$request->contact
        ]);
    }

    public function destroy(Request $request)
    {
        //return 'heyyyyy';
        return $request;
        return GasStation::destroy($gasStation->id);
    }

    public function delete($id){
        return GasStation::destroy($id);
    }
}
