<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EndAtGreaterThanStartAtRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Perform your validation logic here
        $startAt = request()->input('start_at');
        return strtotime($value) > strtotime($startAt);
    }

    public function message()
    {
        return '結束日期必須大於開始日期';
    }
}
