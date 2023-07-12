<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'area' => ['required'],
            'menu' => ['required'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'status' => ['required', 'numeric', Rule::in([0, 1])],
            'title' => ['required'],
            'content' => ['required'],
            'cover' => ['image', 'mimes:png,jpeg,jpg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'area.required' => '請填入區域',
            'menu.required' => '請填入選單',
            'start_at.required' => '請填入開始時間',
            'start_at.date' => '開始時間必須是一個有效日期',
            'end_at.required' => '請填入結束時間',
            'end_at.date' => '結束時間必須是一個有效日期',
            'end_at.after' => '結束時間必須大於開始時間',
            'status.required' => '請填入狀態',
            'status.numeric' => '狀態必須是顯示或隱藏',
            'status.in' => '狀態必須是顯示或隱藏',
            'title.required' => '請填入標題',
            'content.required' => '請填入內容',
            'cover.image' => '封面必須是一個圖片',
            'cover.mimes' => '封面必須是 png, jpeg, jpg 格式',
            'cover.max' => '封面大小不能超過 2MB',
        ];
    }
}
