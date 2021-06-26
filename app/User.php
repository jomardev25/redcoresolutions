<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\RequestFilter;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, RequestFilter;

    protected $fillable = ['name', 'email', 'password', 'role_id'];
    protected $hidden = ['password'];
    protected $rememberTokenName = false;
    protected $filterFields = ['users.name', 'email', 'roles.name'];

    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
