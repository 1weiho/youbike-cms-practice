<?php

namespace App\Rules;

use App\Models\Area;
use Illuminate\Contracts\Validation\Rule;

class UniqueArea implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if a area with the given title already exists
        $areaModel = new Area();
        return !$areaModel->isExist($value);
    }

    public function message()
    {
        return '此名稱已存在。';
    }
}

