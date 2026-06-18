<?php

namespace App\Models;

// Import Laravel's built-in authenticated user class and call it Authenticatable in this file.
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; 

class Admin extends Authenticatable implements JWTSubject 
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * The subject of the JWT (usually the user's ID)
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Extra custom claims to embed inside the token (can leave empty)
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}