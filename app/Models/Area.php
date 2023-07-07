<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $collection = 'area';
    protected $connection = 'mongodb';

    protected $fillable = [
        'name'
    ];
}
