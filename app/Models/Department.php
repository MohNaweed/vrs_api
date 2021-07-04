<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function users(){
        return $this->hasMany(User::class);
    }

    public function requestVehicles()
    {
        return $this->hasManyThrough(RequestVehicle::class, User::class);
    }

    public function approves(){
        return $this->hasMany(Approve::class);
    }
}
