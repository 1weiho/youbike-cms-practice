<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\x7f-\xffA-Za-z\s]+$/',
            'email' => 'required|email|max:50',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('lang.name.required'),
            'name.regex' => __('lang.name.regex'),
            'email.required' => __('lang.email.required'),
            'email.email' => __('lang.email.email'),
            'email.max' => __('lang.email.max'),
            'status.required' => __('lang.status.required'),
        ];
    }
}
