<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mechanic extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'specialization', 'experience', 'availability', 'rating', 'email', 'password', 'location'];

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
}
