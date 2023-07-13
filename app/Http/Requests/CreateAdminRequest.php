<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'username' => 'required|unique:admin|regex:/^[A-Za-z0-9_-]{5,30}$/',
            'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*\d).{8,20}$/',
            'confirmPassword' => 'required|same:password',
            'name' => 'required|regex:/^[\x7f-\xffA-Za-z\s]{3,10}+$/',
            'email' => 'required|unique:admin|email|max:50',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => __('lang.username.required'),
            'username.unique' => __('lang.username.unique'),
            'username.regex' => __('lang.username.regex'),
            'username.max' => __('lang.username.max'),
            'password.required' => __('lang.password.required'),
            'password.regex' => __('lang.password.regex'),
            'confirmPassword.required' => __('lang.confirmPassword.required'),
            'confirmPassword.same' => __('lang.confirmPassword.same'),
            'name.required' => __('lang.name.required'),
            'name.regex' => __('lang.name.regex'),
            'email.required' => __('lang.email.required'),
            'email.unique' => __('lang.email.unique'),
            'email.email' => __('lang.email.email'),
            'email.max' => __('lang.email.max'),
            'status.required' => __('lang.status.required')
        ];
    }
}
