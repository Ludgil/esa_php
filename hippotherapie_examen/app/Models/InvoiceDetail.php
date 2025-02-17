<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable = ['invoice_id', 'appointment_id', 'price'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
