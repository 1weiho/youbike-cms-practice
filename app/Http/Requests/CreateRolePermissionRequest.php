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
            'role_name.required' => __('lang.role_name.required'),
            'role_name.unique' => __('lang.role_name.unique'),
            'role_name.min' => __('lang.role_name.min'),
            'role_name.max' => __('lang.role_name.max'),
            'area_permission_id.required' => __('lang.area_permission_id.required'),
            'access_permission.required' => __('lang.access_permission.required'),
        ];
    }
}
