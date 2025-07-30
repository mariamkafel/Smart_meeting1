<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{

    protected $table = 'users';

    protected $primaryKey = 'Id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    // Fillable fields
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
}
