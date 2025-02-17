<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = ['week_number', 'year', 'start_date', 'end_date'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'week_id');
    }

    public function ponies()
    {
        return $this->belongsToMany(Pony::class, 'pony_weeks')
                ->withPivot('max_work_hours')
                ->withTimestamps();
    }
}
