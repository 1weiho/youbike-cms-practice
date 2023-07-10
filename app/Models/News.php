<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $collection = 'news';
    protected $connection = 'mongodb';

    protected $fillable = [
        'area',
        'menu',
        'start_at',
        'end_at',
        'status',
        'title',
        'content',
    ];
}
