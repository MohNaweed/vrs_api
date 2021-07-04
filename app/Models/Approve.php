<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approve extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function approveable()
    {
        return $this->morphTo();
    }


    public function department(){
        return $this->belongsTo(Department::class);
    }

}
