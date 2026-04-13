<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdBannerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermission('manage_content');
    }

    public function rules()
    {
        return [
            'title'       => 'nullable|string|max:255',
            'images'      => 'sometimes|array|min:1|max:10',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link'        => 'nullable|string|max:255',
            'is_active'   => 'boolean',
            'order'       => 'integer|min:0',
        ];
    }
}
