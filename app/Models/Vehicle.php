<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Driver;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function getDriverIdAttribute($value)
    {
        // if(Request::has('activity'))
            return Driver::find($value);

        // return $value;
    }
}
