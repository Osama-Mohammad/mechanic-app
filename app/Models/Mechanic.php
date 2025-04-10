<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mechanic extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'specialization', 'experience', 'availability', 'rating', 'email', 'password', 'location', 'longitude', 'latitude', 'start_time', 'end_time', 'workdays'];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function emergencyRequests()
    {
        return $this->hasMany(EmergencyRequest::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class);
    }

    public function getPriceAttribute()
    {
        return $this->serviceTypes()->price ?? 0;
    }

    /*
            What is an Accessor in Laravel?
        In Laravel, an accessor is a method in your Eloquent model that allows you to define a custom attribute
         that can be accessed like a property.
        Accessors are typically used to compute or format values dynamically.

        The naming convention for accessors is:

        Start with get.

        Follow with the StudlyCase name of the attribute you want to define.

        End with Attribute.
    */
}
