<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PonyWeek extends Model
{

    public function pony()
    {
        return $this->belongsTo(Pony::class);
    }

    public function week()
    {
        return $this->belongsTo(Week::class);
    }
}
