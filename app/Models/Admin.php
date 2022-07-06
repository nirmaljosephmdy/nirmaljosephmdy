<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guard = 'admin';
    protected $collection='admins';
    protected $fillable = [

        'name',
        'usertype',
        'email',
        'gender',
        'profilepic',
        'password',
        'status',

    ];
}
