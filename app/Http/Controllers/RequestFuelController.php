<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\RequestFuel;
use App\Models\Driver;
use App\Models\Department;
use App\Models\User;
use App\Models\Approve;
use Illuminate\Http\Request;

class RequestFuelController extends Controller
{

    public function clearedRequest(){
        $user = User::find(auth()->id());

        $user->department;
        if($user->department->name === 'Transport'  && $user->department_position === 'head'){

            $requests = RequestFuel::with(['approve.department','driver.vehicle','gasstation'])->whereHas('approve', function (Builder $query){

                $query->where('approved', 1);
            })->get();

            return $requests;
        }
    }

    public function pendingRequests(){

        $user = User::find(auth()->id());


        $user->department;
        if($user->department->name === 'Transport'  && $user->department_position === 'head'){

            $requests = RequestFuel::with(['approve.department','driver.vehicle','gasstation'])->whereHas('approve', function (Builder $query){

                $query->where('approved', 0);
            })->get();

            return $requests;
        }
    }

    public function index()
    {
        $user = User::find(auth()->id());
        return RequestFuel::with(['approve.department','driver.vehicle','gasstation'])->where('user_id',$user->id)->get();
    }


    public function store(Request $request)
    {

        $transport = Department::where('name','Transport')->first();
        $driver = Driver::where('user_id',auth()->id())->first();

        DB::transaction(function () use($transport,$driver,$request) {
            $newRequest = RequestFuel::create([
                'user_id' => auth()->id(),
                'driver_id' => $driver->id,
                'distance_km' => $request->SKM,
                'fuel_type' => $request->fuelType
            ]);

            $newRequest->approve()->create([

                'department_id' => $transport->id,
                'comment' => 'default comment',
                'approved' => false
            ]);
        });
        return 'success';
    }



    public function requestApproved(Request $request){



            $fuelRequest = RequestFuel::find($request->requestID);

            $fuelRequest->fuel_quantity = (int) $request->quantity ;
            $fuelRequest->fuel_price = (int) $request->price;
            $fuelRequest->gas_station_id = (int) $request->gasStationID;
            $fuelRequest->save();


            $app = Approve::find($request->approveID);
            $app->approved = 1;
            $app->save();


        return 'success';
    }
}
