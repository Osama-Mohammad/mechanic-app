<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'service_request_id', 'amount', 'method', 'status', 'transaction_date'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}
