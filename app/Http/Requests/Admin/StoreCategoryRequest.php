<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // OPTIMIZED: Check parent eligibility with single query
                        $parentData = DB::table('categories as c')
                            ->leftJoin('products as p', 'c.id', '=', 'p.category_id')
                            ->where('c.id', $value)
                            ->select(
                                'c.depth',
                                'c.is_active',
                                DB::raw('COUNT(DISTINCT p.id) as products_count')
                            )
                            ->groupBy('c.id', 'c.depth', 'c.is_active')
                            ->first();

                        if (!$parentData) {
                            $fail('The selected parent category does not exist.');
                            return;
                        }

                        // Check if parent can have children (depth limit)
                        if ($parentData->depth >= Category::MAX_DEPTH) {
                            $fail('The selected parent category has reached maximum depth and cannot have children.');
                            return;
                        }

                        // Check if parent is active
                        if (!$parentData->is_active) {
                            $fail('Cannot create category under an inactive parent category.');
                            return;
                        }

                        // Check if parent has products
                        if ($parentData->products_count > 0) {
                            $fail('Cannot create subcategory under a category that has products assigned. Products can only be assigned to leaf categories.');
                            return;
                        }
                    }
                },
            ],
            'description_en' => ['nullable', 'string'],
            'description_bn' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'is_featured' => ['boolean'],
            'show_in_nav' => ['boolean'],
            'is_active' => [
                'boolean',
                function ($attribute, $value, $fail) {
                    // If trying to create as active, check if parent is active
                    if ($value && $this->parent_id) {
                        // OPTIMIZED: Check parent active status with single query
                        $parentActive = DB::table('categories')
                            ->where('id', $this->parent_id)
                            ->where('is_active', true)
                            ->exists();

                        if (!$parentActive) {
                            $fail('Cannot activate category when parent category is inactive.');
                            return;
                        }
                    }
                },
            ],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'nav_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_en.required' => 'English category name is required.',
            'name_en.string' => 'English name must be a valid text.',
            'name_en.max' => 'English name cannot exceed 255 characters.',
            'name_bn.string' => 'Bengali name must be a valid text.',
            'name_bn.max' => 'Bengali name cannot exceed 255 characters.',
            'slug.string' => 'Slug must be a valid text.',
            'slug.max' => 'Slug cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'description_en.string' => 'English description must be a valid text.',
            'description_bn.string' => 'Bengali description must be a valid text.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be in PNG, JPG, JPEG, or WEBP format.',
            'image.max' => 'Image size cannot exceed 2MB.',
            'is_featured.boolean' => 'Featured flag must be true or false.',
            'show_in_nav.boolean' => 'Navigation display flag must be true or false.',
            'is_active.boolean' => 'Active status must be true or false.',
            'meta_title.string' => 'Meta title must be a valid text.',
            'meta_title.max' => 'Meta title cannot exceed 255 characters.',
            'meta_description.string' => 'Meta description must be a valid text.',
            'meta_keywords.string' => 'Meta keywords must be a valid text.',
            'order.integer' => 'Order must be a whole number.',
            'order.min' => 'Order cannot be negative.',
            'nav_order.integer' => 'Navigation order must be a whole number.',
            'nav_order.min' => 'Navigation order cannot be negative.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Auto-generate slug from English name if not provided
        if (!$this->has('slug') && $this->has('name_en')) {
            $this->merge([
                'slug' => Str::slug($this->name_en),
            ]);
        }

        // Ensure boolean values
        $booleans = ['is_featured', 'show_in_nav', 'is_active'];

        foreach ($booleans as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->$field, FILTER_VALIDATE_BOOLEAN),
                ]);
            } else {
                $this->merge([$field => false]);
            }
        }

        // Set default values
        if (!$this->has('order')) $this->merge(['order' => 0]);
        if (!$this->has('nav_order')) $this->merge(['nav_order' => 0]);
        if (!$this->has('is_active')) $this->merge(['is_active' => true]);

        // Clean up empty strings to null
        $nullableFields = ['name_bn', 'description_en', 'description_bn', 'meta_title', 'meta_description', 'meta_keywords'];

        foreach ($nullableFields as $field) {
            if ($this->has($field) && trim($this->$field) === '') {
                $this->merge([$field => null]);
            }
        }
    }
}
