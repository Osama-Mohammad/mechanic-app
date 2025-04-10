<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['name', 'price', 'mechanic_id'];

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }


}
