<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Logger extends Model
{
    protected $collection = 'log';
    protected $connection = 'mongodb';

    protected $fillable = [
        'time',
        'method',
        'status',
        'ip',
        'route',
        'api_name',
        'request_uri',
        'referer',
        'request',
        'response',
        'user',
        'total_time',
        'extra'
    ];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
        'extra' => 'array',
    ];
}
