<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'method', 'status', 'customer_id', 'service_request_id', 'transaction_date', 'reference_id',];
    protected $casts = [
        'transaction_date' => 'datetime', // This will automatically convert to Carbon
    ];

    /* 'customer_id', 'service_request_id', 'amount', 'method', 'status', 'transaction_date' */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }
}
