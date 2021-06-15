<?php

namespace App\Http\Controllers;

use DB;
use App\Models\RequestVehicle as Request;
use App\Models\Department;
use App\Models\Approve;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request as RequestResult;
use App\Notifications\requestVehicle;

class RequestController extends Controller
{

    public function test(){

        $user = User::find(auth()->id());
        //return $user;
        $user->notify(new requestVehicle('newthing'));
        return 0;

    }


    public function allRequest(){



         //get transport and administration departments id
        $transport = Department::where('name','Transport')->first();
        $administration = Department::where('name','Administration')->first();


        $currentUser = User::find(Auth()->id());
        $requestedUserPosition = $currentUser->department_position;
        $requestedUserDepartment = $currentUser->department->name;
        $allRequest = Request::withCount('approves')->get();
        foreach($allRequest as $req){
            $req->approves;
            $user = $req->user;
            $req->source = Location::find($req->source_id)->address;
            $req->destination = Location::find($req->destination_id)->address;
            foreach($req->approves as $app){
                $app->department = Department::find($app->department_id)->name;
            }
        }




        //return requests which their transport's approval was to true;
        $requests = [];
        if ($requestedUserDepartment == "Administration" || ($requestedUserPosition == "head"  && $requestedUserDepartment == "Transport"))
        {
            foreach ($allRequest as $req)
            {

                if($req->approves_count == 1)
                {
                    array_push($requests,$req);
                }
                else
                {

                    foreach($req->approves as $app)
                    {
                        if($app->department_id != $administration->id && $app->department_id != $transport->id   && $app->approved == true)
                            array_push($requests,$req);
                    }

                }

            }
        }
        elseif($requestedUserPosition == "head"){
            foreach ($allRequest as $req)
            {
                foreach($req->approves as $app)
                {
                    if($app->department_id == $currentUser->department_id)
                        array_push($requests,$req);
                }

            }
        }

        return $requests;

        //return $requestedUserDepartment;
    }

    public function index()
    {
        $request = Request::all();
        $user = User::find(auth()->id());
        $department = $user->department;
        $requests = $user->requests;
        foreach ($requests as $req){
            $req->approves;
        }
        //$approves = $requests[0]->approves;
        $departmentPositon = $user->department_position;
        return $user;


    }



    public function store(RequestResult $request_result)
    {

        //return $request_result;
        // return auth()->id();

        $user = User::find(auth()->id());
        $department = $user->department;


        //get transport and admin departments id
        $transport = Department::where('name','Transport')->first();
        $administration = Department::where('name','Administration')->first();


        DB::transaction(function () use($request_result,$user,$department,$transport,$administration) {
            $newRequest =  Request::create([
                'user_id' => auth()->id(),
                'purpose'=> $request_result->purpose ?? 'default purpose',
                'passenger_name' => $request_result->passengerName ?? null,
                'passenger_contact' => $request_result->passengerContact ?? null,
                'travel_time' => '12:16',
                'return_time' => '11:30',
                'source_id' => $request_result->source_id ?? null,
                'destination_id' => $request_result->destination_id,
                'return' => $request_result->isReturn ?? false,
                'driver_id'=>1
            ]);

            // condition for creating approved records
            if(($user->department_position == 'head' && $department->name == 'Transport') || $department->name == 'Administration' )
            {
                //return 'head security';
                $newRequest->approves()->create([

                    'department_id' => $user->department_id,
                    'comment' => 'default comment',
                    'approved' => true
                ]);
            }
            else if($user->department_position == 'normal' && $department->name == 'Transport' )
            {
                //return 'normal security';
                $newRequest->approves()->create([

                    'department_id' => $department->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
            }
            elseif($user->department_position == 'head')
            {
                //return 'head others';
                $newRequest->approves()->create([

                    'department_id' => $department->id,
                    'comment' => 'default comment',
                    'approved' => true
                ]);
                $newRequest->approves()->create([

                    'department_id' => $administration->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
            }
            else{
                //return 'normal others';
                $newRequest->approves()->create([

                    'department_id' => $department->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
                $newRequest->approves()->create([

                    'department_id' => $administration->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
            }

        });



    }


    public function show(Request $request)
    {
        //
    }


    public function update(RequestResult $request_result, Request $request)
    {
        //
    }


    public function destroy(Request $request)
    {
        //
    }

    public function requestApproved(RequestResult $request_result){

        $app = Approve::find($request_result->approveID);
        $app->approved = 1;
        $app->save();

        $req = Request::find($request_result->requestID);
        $req->driver_id = $request_result->driverID ?? 0;
        $req->save();

        return $request_result;
    }
}
