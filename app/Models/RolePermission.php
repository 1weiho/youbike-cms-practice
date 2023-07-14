<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class RolePermission extends Model
{
    protected $collection = 'role_permission';
    protected $connection = 'mongodb';

    protected $fillable = [
        'role_name',
        'account_id',
        'area_permission_id',
        'access_permission',
    ];

    public function foo() {
        dd(1);
    }

    public function account()
    {
        $role_permission_id = $this->_id;
        return Admin::where('role_permission_id', $role_permission_id)->get();
    }

    public function area_permission()
    {
        $areaIds = $this->area_permission_id;

        foreach ($areaIds as $key => $value) {
            $areaIds[$key] = new \MongoDB\BSON\ObjectId($value);
        }

        return Area::whereIn('_id', $areaIds)->get();
    }
}
