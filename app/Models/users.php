<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'PasswordHash',
        'Role',
        'Department',
        'IsActive',
        'ProfileImageUrl',
        'LastSeenDate',
        'CreatedDate',
        'UpdatedDate',
    ];

    // Tell Laravel which field to use for password
    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }

    // Required for JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Optional custom claims
    public function getJWTCustomClaims()
    {
                return [];
   
    }
}