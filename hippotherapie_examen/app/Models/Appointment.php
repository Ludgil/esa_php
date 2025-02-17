<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $fillable = ['week_id', 'appointment_date', 'start_hour', 'end_hour', 'price', 'number_of_people', 'customer_id', 'billed'];
    
    public function week()
    {
        return $this->belongsTo(Week::class);
    }
    
    public function ponies()
    {
        return $this->belongsToMany(Pony::class, 'appointment_ponies');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_details');
    }
}
