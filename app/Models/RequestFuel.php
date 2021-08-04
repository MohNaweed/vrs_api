<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Approve;

class RequestFuel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function approve()
    {
        return $this->morphOne(Approve::class, 'approveable');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function gasstation()
    {
        return $this->belongsTo(GasStation::class,'gas_station_id');
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }
}
