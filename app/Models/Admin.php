<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Admin extends Model
{

    protected $collection = 'admin';
    protected $connection = 'mongodb';

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'status'
    ];
}
