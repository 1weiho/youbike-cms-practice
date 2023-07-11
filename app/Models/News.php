<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class News extends Model
{

    protected $collection = 'news';
    protected $connection = 'mongodb';

    protected $fillable = [
        'area_id',
        'menu_id',
        'start_at',
        'end_at',
        'status',
        'title',
        'content',
    ];

    public function area()
    {
        $areaIds = $this->area_id;

        foreach ($areaIds as $key => $value) {
            $areaIds[$key] = new \MongoDB\BSON\ObjectId($value);
        }

        return Area::whereIn('_id', $areaIds)->get();

    }

    public function menu()
    {
        $menuId = $this->menu_id;
        
        return Menu::where('_id', $menuId)->first();
    }
}
