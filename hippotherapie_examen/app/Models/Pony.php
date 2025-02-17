<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pony extends Model
{
    protected $fillable = ['name'];

    public function weeks()
    {
        return $this->belongsToMany(Week::class, 'pony_weeks')
                ->withPivot('max_work_hours')
                ->withTimestamps();
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_ponies');
    }
}
