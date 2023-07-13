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
            'name.required' => '請填入姓名',
            'name.regex' => '姓名僅能輸入中文、英文及空白，且長度為 3-10 個字元',
            'email.required' => '請填入信箱',
            'email.email' => '信箱格式錯誤',
            'email.max' => '信箱長度不能超過 50 個字元',
            'status.required' => '請填入狀態'
        ];
    }
}
