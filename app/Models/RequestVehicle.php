<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Approve;

class RequestVehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function approves()
    {
        return $this->morphMany(Approve::class, 'approveable');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function driverVehicle(){
        return $this->hasOneThrough(Vehicle::class, Driver::class);
    }

    public function sourceLocation(){
        return $this->belongsTo(Location::class,'source_id');
    }

    public function destinationLocation(){
        return $this->belongsTo(Location::class,'destination_id');
    }
}
