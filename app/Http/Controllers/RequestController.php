<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\RequestVehicle as Request;
use App\Models\Department;
use App\Models\Approve;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request as RequestResult;
use App\Notifications\requestVehicle;
use App\Notifications\RequestVehicleNotification;

class RequestController extends Controller
{

    public function test(){

        $user = User::find(auth()->id());
        //return $user;
        $user->notify(new requestVehicle('newthing'));
        return 0;

    }

    public function belongsRequests(){
        $currentUser = User::find(Auth()->id());
        $requestedUserPosition = $currentUser->department_position;
        $requestedUserDepartment = $currentUser->department->name;
        if($requestedUserPosition === 'head' && ($requestedUserDepartment === 'Security' || $requestedUserDepartment === 'Transport')){
            return Request::where('status','!=','clear')->get();
        }
        else if ($requestedUserPosition === 'head'){
            $department = Department::find($currentUser->department_id);
            return $department->requestVehicles->where('status','!=','clear');;

        }
    }



    public function clearedRequests(){
        $currentUser = User::find(Auth()->id());
        $requestedUserPosition = $currentUser->department_position;
        $requestedUserDepartment = $currentUser->department->name;
        $requestedUserDepartmentID = $currentUser->department->id;
        if($requestedUserPosition === 'head' && ($requestedUserDepartment === 'Security' || $requestedUserDepartment === 'Transport')){

            return Request::with(['sourceLocation','destinationLocation','approves.department','user.department','driver.vehicle'])->where('status','clear')->get();

        }
        else if ($requestedUserPosition === 'head'){
            // $department = Department::find($currentUser->department_id);
            // return $department->requestVehicles->where('status','clear');
            return Request::with(['sourceLocation','destinationLocation','approves.department','user.department','driver.vehicle'])->whereHas('user', function (Builder $query) use($requestedUserDepartmentID){

                $query->where('department_id', $requestedUserDepartmentID);
            })->get();

        }
    }
    public function allRequest(){

        $currentUser = User::find(Auth()->id());

        if($currentUser->department_position === 'head'){
            return Request::with(['sourceLocation','destinationLocation','approves.department','user.department','driver.vehicle'])->where('status',$currentUser->department->name)->get();
        }
        return [];

    }

    public function index()
    {


        $user = User::find(auth()->id());

        return Request::with(['sourceLocation','destinationLocation','approves.department','user.department','driver.vehicle'])->where('user_id',$user->id)->get();


    }



    public function store(RequestResult $request_result)
    {

        //return $request_result;
        // return auth()->id();

        $user = User::find(auth()->id());
        $department = $user->department;


        //get transport and security departments id
        $transport = Department::where('name','Transport')->first();
        $security = Department::where('name','Security')->first();


        DB::transaction(function () use($request_result,$user,$department,$transport,$security) {
            $newRequest =  Request::create([
                'user_id' => auth()->id(),
                'purpose'=> $request_result->purpose ?? 'default purpose',
                'passenger_name' => $request_result->passengerName ?? null,
                'passenger_contact' => $request_result->passengerContact ?? null,
                'comment' => $request_result->comment ?? null,
                'travel_time' => $request_result->travelTime,
                'return_time' => $request_result->returnTime,
                'source_id' => $request_result->source_id ?? null,
                'destination_id' => $request_result->destination_id,
                'return' => $request_result->isReturn ?? false,
                'status' => 'initial',
                'driver_id'=>$request_result->driverID
            ]);

            $newRequest->user;

            // condition for creating approved records
            if($user->department_position == 'head' && $department->name == 'Security')
            {
                //return 'head security';
                $newRequest->approves()->create([

                    'department_id' => $security->id,
                    'comment' => 'default comment',
                    'approved' => true
                ]);
                $newRequest->approves()->create([

                    'department_id' => $transport->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);

                $newRequest->status = $transport->name;
                $newRequest->save();

                //Notification sent to all head of Transport Department
                $this->sendNotification($transport->id, $newRequest);
            }
            else if($department->name == 'Security'){

                $newRequest->approves()->create([

                    'department_id' => $security->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
                $newRequest->approves()->create([

                    'department_id' => $transport->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);

                $newRequest->status = $security->name;
                $newRequest->save();


                //Notification sent to all head of Transport Department
                $this->sendNotification($security->id, $newRequest);

            }
            else if($user->department_position == 'head' && $department->name == 'Transport' )
            {
                //return 'normal security';
                $newRequest->approves()->create([

                    'department_id' => $transport->id,
                    'comment' => 'default comment',
                    'approved' => true
                ]);
                $newRequest->approves()->create([

                    'department_id' => $security->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);

                $newRequest->status = $security->name;
                $newRequest->save();


                //Notification sent to all head of Transport Department
                $this->sendNotification($security->id, $newRequest);
            }
            else if($department->name == 'Transport'){
                $newRequest->approves()->create([

                    'department_id' => $transport->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
                $newRequest->approves()->create([

                    'department_id' => $security->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);

                $newRequest->status = $transport->name;
                $newRequest->save();


                 //Notification sent to all head of Transport Department
                $this->sendNotification($transport->id, $newRequest);
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

                    'department_id' => $transport->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
                $newRequest->approves()->create([

                    'department_id' => $security->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);

                $newRequest->status = $transport->name;
                $newRequest->save();

                 //Notification sent to all head of Transport Department
                $this->sendNotification($transport->id, $newRequest);
            }
            else{

                $newRequest->approves()->create([

                    'department_id' => $department->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
                $newRequest->approves()->create([

                    'department_id' => $transport->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);
                $newRequest->approves()->create([

                    'department_id' => $security->id,
                    'comment' => 'default comment',
                    'approved' => false
                ]);

                $newRequest->status = $department->name;
                $newRequest->save();


                 //Notification sent to all head of Transport Department
                $this->sendNotification($department->id, $newRequest);
            }

        });



    }

    public function requestApproved(RequestResult $request_result){

        //get transport and security departments id
        $transport = Department::where('name','Transport')->first();
        $security = Department::where('name','Security')->first();

        $user = User::find(auth()->id());
        $requestDepartment = Request::find($request_result->requestID)->user->department;

        $app = Approve::find($request_result->approveID);
        $app->approved = 1;
        $app->save();

        $req = Request::find($request_result->requestID);
        $req->user;
        $req->driver_id = $request_result->driverID ?? 0;

        if($user->department_position === 'head' && $user->department->name === $security->name){
            if($requestDepartment->name === $security->name){
                $req->status = $transport->name;
                $req->save();
                $this->sendNotification($transport->id,$req);
            }
            else{
                $req->status = 'clear';
                $req->save();
                $user = User::find($req->user_id);
                $user->notify(new RequestVehicleNotification($req));
            }
        }
        else if($user->department_position === 'head' && $user->department->name === $transport->name){
            if($requestDepartment->name === $security->name){
                $req->status = 'clear';
                $req->driver_id = $request_result->driverID;
                $req->save();
                $user = User::find($req->user_id);
                $user->notify(new RequestVehicleNotification($req));
            }
            else{
                $req->status = $security->name;
                $req->driver_id = $request_result->driverID;
                $req->save();
                $this->sendNotification($security->id,$req);
            }
        }
        else if($user->department_position === 'head'){
                $req->status = $transport->name;
                $req->save();
                $this->sendNotification($transport->id,$req);
        }

       // $req->save();


        return $request_result;
    }





    private function sendNotification($departmentID,$requestData){
       //Notification sent to all head of Transport Department
        $usersnotify = User::where([
            ['department_position','=','head'],
            ['department_id','=',$departmentID]
            ])->get();


        foreach($usersnotify as $un){
            $un->notify(new RequestVehicleNotification($requestData));
        }
    }
}
