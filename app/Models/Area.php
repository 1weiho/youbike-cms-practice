<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Area extends Model
{

    protected $collection = 'area';
    protected $connection = 'mongodb';

    protected $fillable = [
        'name'
    ];
}
