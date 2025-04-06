<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{


    use HasFactory, Notifiable;

    protected $fillable = ['name', 'phone', 'location', 'registration_date', 'email', 'password'];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function emergencyRequests()
    {
        return $this->hasMany(EmergencyRequest::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
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
