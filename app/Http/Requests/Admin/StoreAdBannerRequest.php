<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdBannerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermission('manage_content');
    }

    public function rules()
    {
        return [
            'title'       => 'nullable|string|max:255',
            'images'      => 'required|array|min:1|max:10',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max per image
            'link'        => 'nullable|string|max:255',
            'is_active'   => 'boolean',
            'order'       => 'integer|min:0',
        ];
    }
}
