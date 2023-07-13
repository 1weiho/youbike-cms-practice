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
            'area.required' => __('lang.area.required'),
            'menu.required' => __('lang.menu.required'),
            'start_at.required' => __('lang.start_at.required'),
            'start_at.date' => __('lang.start_at.date'),
            'end_at.required' => __('lang.end_at.required'),
            'end_at.date' => __('lang.end_at.date'),
            'end_at.after' => __('lang.end_at.after'),
            'status.required' => __('lang.status.required'),
            'status.numeric' => __('lang.status.numeric'),
            'status.in' => __('lang.status.in'),
            'title.required' => __('lang.title.required'),
            'content.required' => __('lang.content.required'),
            'cover.image' => __('lang.cover.image'),
            'cover.mimes' => __('lang.cover.mimes'),
            'cover.max' => __('lang.cover.max'),
        ];
    }
}
