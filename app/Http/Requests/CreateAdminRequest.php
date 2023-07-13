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
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
            'name' => 'required|regex:/^[\x7f-\xffA-Za-z\s]+$/',
            'email' => 'required|unique:admin|email|max:50',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '請填入帳號',
            'username.unique' => '帳號已存在',
            'username.regex' => '帳號僅能輸入數字、英文及_-符號，且長度為 5-30 個字元',
            'username.max' => '帳號長度不能超過 255 個字元',
            'password.required' => '請填入密碼',
            'password.regex' => '密碼必須包含英文及數字，且長度為 8-20 個字元',
            'confirmPassword.required' => '請填入確認密碼',
            'confirmPassword.same' => '確認密碼與密碼不相符',
            'name.required' => '請填入姓名',
            'name.regex' => '姓名僅能輸入中文、英文及空白，且長度為 3-10 個字元',
            'email.required' => '請填入信箱',
            'email.unique' => '信箱已存在',
            'email.email' => '信箱格式錯誤',
            'email.max' => '信箱長度不能超過 50 個字元',
            'status.required' => '請填入狀態'
        ];
    }
}
