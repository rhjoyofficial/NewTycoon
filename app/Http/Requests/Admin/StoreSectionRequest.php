<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSectionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->hasPermission('manage_content');
    }

    public function rules()
    {
        return [
            'name'          => 'nullable|string|max:255',
            'title_en'         => 'nullable|string|max:255',
            'title_bn'         => 'nullable|string|max:255',
            'type'          => ['required', Rule::in(['product_slider', 'banner'])],
            'order'         => 'integer|min:0',
            'is_active'     => 'boolean',
            'settings'      => 'nullable|json',
            'ad_banner_id'  => 'nullable|exists:ad_banners,id',
        ];
    }
}
