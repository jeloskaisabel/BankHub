<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'password', 'persona_id', 'rol'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function getEmailAttribute()
    {
        return $this->persona ? $this->persona->email : 'No Email';
    }
}
