<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GasStation extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function requestfuels(){
        return $this->hasMany(RequestFuel::class,'gas_station_id');
    }
}
