<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Menu;

class UniqueMenu implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if a menu with the given title already exists
        $menuModel = new Menu();
        return !$menuModel->isExist($value);
    }

    public function message()
    {
        return '此名稱已存在。';
    }
}
