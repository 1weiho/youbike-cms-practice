<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Menu extends Model
{

    protected $collection = 'menu';
    protected $connection = 'mongodb';

    protected $fillable = [
        'name'
    ];
    
}
