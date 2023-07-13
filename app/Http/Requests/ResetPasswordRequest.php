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
            'password.required' => __('lang.password.required'),
            'password.regex' => __('lang.password.regex'),
            'confirmPassword.required' => __('lang.confirmPassword.required'),
            'confirmPassword.same' => __('lang.confirmPassword.same'),
        ];
    }
}
