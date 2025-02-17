<?php

namespace App\Models;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name'];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
