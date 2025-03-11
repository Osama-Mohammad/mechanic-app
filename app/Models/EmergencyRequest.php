<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyRequest extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'mechanic_id', 'description', 'location', 'status', 'response_time'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }
}
