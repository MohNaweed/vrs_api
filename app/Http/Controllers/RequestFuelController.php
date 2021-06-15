<?php

namespace App\Http\Controllers;

use DB;
use App\Models\RequestFuel;
use App\Models\Driver;
use App\Models\Department;
use App\Models\User;
use App\Models\Approve;
use Illuminate\Http\Request;

class RequestFuelController extends Controller
{

    public function allRequest(){
        $user = User::find(auth()->id());

        $user->department;
        if($user->department->name === 'Administration' || ($user->department->name === 'Transport'  && $user->department_position === 'head')){

            $requests = RequestFuel::withCount('approves')->get();

            foreach($requests as $req){
                $req->approves;
            }

            return $requests;
        }
    }

    public function index()
    {
        //
    }


    public function store(Request $request)
    {

        $transport = Department::where('name','Transport')->first();
        $driver = Driver::where('user_id',auth()->id())->first();

        DB::transaction(function () use($transport,$driver,$request) {
            $newRequest = RequestFuel::create([
                'driver_id' => $driver->id,
                'distance_km' => $request->SKM,
                'fuel_type' => $request->fuelType
            ]);

            $newRequest->approves()->create([

                'department_id' => $transport->id,
                'comment' => 'default comment',
                'approved' => false
            ]);
        });
        return 'success';
    }


    public function show(RequestFuel $requestFuel)
    {
        //
    }


    public function update(Request $request, RequestFuel $requestFuel)
    {
        //
    }


    public function destroy(RequestFuel $requestFuel)
    {
        //
    }

    public function requestApproved(Request $request){



            $fuelRequest = RequestFuel::find($request->requestID);

            $fuelRequest->fuel_quantity = (int) $request->quantity ;
            $fuelRequest->fuel_price = (int) $request->price;
            $fuelRequest->save();


            $app = Approve::find($request->approveID);
            $app->approved = 1;
            $app->save();


        return 'success';
    }
}
