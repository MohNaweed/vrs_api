<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class Driver extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function requestvehicles(){
        return $this->hasMany(RequestVehicle::class);
    }

    public function requestFuels(){
        return $this->hasMany(RequestFuel::class);
    }
}
