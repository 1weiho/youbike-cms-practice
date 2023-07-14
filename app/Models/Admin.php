<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Jenssegers\Mongodb\Eloquent\Model;

class Admin extends Model implements Authenticatable
{

    use AuthenticableTrait;

    protected $collection = 'admin';
    protected $connection = 'mongodb';

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'status',
        'role_permission_id',
    ];

    public function role_permission()
    {
        $role_permission_id = $this->role_permission_id;

        return RolePermission::where('_id', $role_permission_id)->first();
    }
}
