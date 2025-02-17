<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['customer_id', 'month', 'total_amount'];
    
    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'invoice_details')
                    ->withPivot('price'); // Inclure le prix dans la relation
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
