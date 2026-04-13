<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'sku' => [
                'nullable',
                'string',
                'max:100',
                'unique:products,sku'
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:products,slug'
            ],
            'short_description_en' => 'nullable|string',
            'short_description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'alert_quantity' => 'nullable|integer|min:0',
            'track_quantity' => 'boolean',
            'allow_backorder' => 'boolean',
            'stock_status' => 'required|in:in_stock,out_of_stock,backorder',
            'model_number' => 'nullable|string|max:100',
            'warranty_period' => 'nullable|integer|min:0',
            'warranty_type' => 'nullable|string|max:100',
            'specifications' => 'nullable|array',
            'featured_images' => 'nullable|array|max:2',
            'featured_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images' => 'nullable|array|max:5',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_title_bn' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string',
            'meta_description_bn' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_bestsells' => 'boolean',
            'is_new' => 'boolean',
            'status' => 'required|in:draft,active,inactive,archived',
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    // OPTIMIZED: Single query with all checks
                    $categoryData = DB::table('categories as c')
                        ->leftJoin('categories as parent', 'c.parent_id', '=', 'parent.id')
                        ->leftJoin('categories as children', 'c.id', '=', 'children.parent_id')
                        ->where('c.id', $value)
                        ->select(
                            'c.is_active',
                            'c.depth',
                            DB::raw('COUNT(DISTINCT children.id) as children_count'),
                            DB::raw('CASE WHEN c.parent_id IS NULL THEN 1 ELSE parent.is_active END as parent_active')
                        )
                        ->groupBy('c.id', 'c.is_active', 'c.depth', 'c.parent_id', 'parent.is_active')
                        ->first();

                    if (!$categoryData) {
                        $fail('The selected category does not exist.');
                        return;
                    }

                    // Check if category is active
                    if (!$categoryData->is_active) {
                        $fail('Cannot assign product to an inactive category.');
                        return;
                    }

                    // Check if category is a leaf (has no children)
                    if ($categoryData->children_count > 0) {
                        $fail('Products can only be assigned to leaf categories (categories without subcategories). Please select a different category or create a new subcategory.');
                        return;
                    }

                    // Check if parent is active
                    if (!$categoryData->parent_active) {
                        $fail('Cannot assign product to this category because one of its parent categories is inactive.');
                        return;
                    }
                },
            ],
            'brand_id' => 'nullable|exists:brands,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category for this product.',
            'category_id.exists' => 'The selected category does not exist.',
            'name_en.required' => 'Product name (English) is required.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price must be greater than or equal to 0.',
            'compare_price.min' => 'Compare price must be greater than or equal to 0.',
            'quantity.required' => 'Quantity is required.',
            'quantity.min' => 'Quantity cannot be negative.',
            'featured_images.max' => 'You can only upload up to 2 featured images.',
            'gallery_images.max' => 'You can only upload up to 5 gallery images.',
            'status.required' => 'Please select a product status.',
            'stock_status.required' => 'Please select stock status.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure boolean fields are properly cast
        $booleans = ['track_quantity', 'allow_backorder', 'is_featured', 'is_bestsells', 'is_new'];

        foreach ($booleans as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->$field, FILTER_VALIDATE_BOOLEAN),
                ]);
            } else {
                $this->merge([$field => false]);
            }
        }
    }
}
