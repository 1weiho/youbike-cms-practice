<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRolePermissionRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'role_name' => 'required|unique:role_permission|min:3|max:15',
            'area_permission_id' => 'required',
            'access_permission' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'role_name.required' => '請輸入角色名稱',
            'role_name.unique' => '角色名稱已存在',
            'role_name.min' => '角色名稱最少3個字',
            'role_name.max' => '角色名稱最多15個字',
            'area_permission_id.required' => '請選擇區域權限',
            'access_permission.required' => '請選擇角色權限',
        ];
    }
}
