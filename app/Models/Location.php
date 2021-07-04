<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function requestSources(){
        return $this->hasMany(RequestVehicle::class,'source_id');
    }

    public function requestDestinations(){
        return $this->hasMany(RequestVehicle::class,'destination_id');
    }
}


