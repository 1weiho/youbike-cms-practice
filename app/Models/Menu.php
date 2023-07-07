<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $collection = 'menu';
    protected $connection = 'mongodb';

    protected $fillable = [
        'name'
    ];
    
}
