<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Request;
use App\Models\Department;
use App\Models\Approval;
use App\Models\User;
use Illuminate\Http\Request as RequestResult;

class RequestController extends Controller
{

    public function allRequest(){

         //get transport and security departments id
         $transport = Department::where('name','Transport')->first();
         $security = Department::where('name','Security')->first();


        $currentUser = User::find(Auth()->id());
        $requestedUserPosition = $currentUser->department_position;
        $requestedUserDepartment = $currentUser->department->name;
        $allRequest = Request::withCount('approvals')->get();
        foreach($allRequest as $req){
            $req->approvals;
        }

        //return requests which their transport's approval was to true;
        $requests = [];
        if ($requestedUserPosition == "head"  && $requestedUserDepartment == "Security")
        {
            foreach ($allRequest as $req)
            {

                if($req->approvals_count == 1)
                {
                    array_push($requests,$req);
                }
                else
                {

                    foreach($req->approvals as $app)
                    {
                        if($app->department_id == $transport->id && $app->approved == true)
                            array_push($requests,$req);
                    }

                }

            }
        }
        elseif($requestedUserPosition == "head"  && $requestedUserDepartment == "Transport")
        {

            foreach ($allRequest as $req)
            {

                if($req->approvals_count == 2)
                {
                    array_push($requests,$req);
                }
                else
                {

                    foreach($req->approvals as $app)
                    {
                        if($app->department_id != $security->id && $app->department_id != $transport->id   && $app->approved == true)
                            array_push($requests,$req);
                    }

                }

            }
        }
        elseif($requestedUserPosition == "head"){
            foreach ($allRequest as $req)
            {
                foreach($req->approvals as $app)
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
            $req->approvals;
        }
        //$approvals = $requests[0]->approvals;
        $departmentPositon = $user->department_position;
        return $user;


    }



    public function store(RequestResult $request_result)
    {
        // return auth()->id();

        $user = User::find(auth()->id());
        $department = $user->department;

        //get transport and security departments id
        $transport = Department::where('name','Transport')->first();
        $security = Department::where('name','Security')->first();


        DB::transaction(function () use($request_result,$user,$department,$transport,$security) {
            $newRequest =  Request::create([
                'user_id' => auth()->id(),
                'purpose'=> $request_result->purpose ?? null,
                'passenger_count' => $request_result->passenger_count ?? null,
                'vehicle_id' => $request_result->vehicle_id ?? null,
                'source_location_request_id' => $request_result->source_location_request_id ?? null,
                'destination_location_request_id' => $request_result->destination_location_request_ids,
                'return' => $request_result->branch_no ?? false,
            ]);

            // condition for creating approved records
            if($user->department_position == 'head' && $department->name == 'Security' )
            {
                //return 'head security';
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $department->id,
                    'comment' => null,
                    'approved' => true
                ]);
            }
            else if($user->department_position == 'normal' && $department->name == 'Security' )
            {
                //return 'normal security';
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $department->id,
                    'comment' => null,
                    'approved' => false
                ]);
            }
            else if($user->department_position == 'head' && $department->name == 'Transport' )
            {
            // return 'head transport';
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $department->id,
                    'comment' => null,
                    'approved' => true
                ]);
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $security->id,
                    'comment' => null,
                    'approved' => false
                ]);
            }
            else if($user->department_position == 'normal' && $department->name == 'Transport' )
            {
            // return 'normal transport';
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $department->id,
                    'comment' => null,
                    'approved' => false
                ]);
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $security->id,
                    'comment' => null,
                    'approved' => false
                ]);
            }
            elseif($user->department_position == 'head')
            {
                //return 'head others';
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $department->id,
                    'comment' => null,
                    'approved' => true
                ]);
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $transport->id,
                    'comment' => null,
                    'approved' => false
                ]);
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $security->id,
                    'comment' => null,
                    'approved' => false
                ]);
            }
            else{
                //return 'normal others';
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $department->id,
                    'comment' => null,
                    'approved' => false
                ]);
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $transport->id,
                    'comment' => null,
                    'approved' => false
                ]);
                Approval::create([
                    'request_id' => $newRequest->id,
                    'department_id' => $security->id,
                    'comment' => null,
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
}
