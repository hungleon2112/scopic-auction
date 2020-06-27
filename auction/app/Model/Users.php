<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->name}";
    }

    public function isAdmin() {
        return $this->role == Constant::ROLE_ADMIN;
    }
    
    public function getAuthPassword()
    {
      return $this->password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'id'              => $this->id,
            'name'              => $this->name,
            'username'       => $this->username,
            'email'           => $this->email,
        ];
    }
}
