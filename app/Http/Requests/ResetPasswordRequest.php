<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*\d).{8,20}$/',
            'confirmPassword' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => '請填入密碼',
            'password.regex' => '密碼必須包含英文及數字，且長度為 8-20 個字元',
            'confirmPassword.required' => '請填入確認密碼',
            'confirmPassword.same' => '確認密碼與密碼不相符',
        ];
    }
}
