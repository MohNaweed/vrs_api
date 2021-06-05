<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Approve;

class RequestFuel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function approves()
    {
        return $this->morphMany(Approve::class, 'approveable');
    }
}
