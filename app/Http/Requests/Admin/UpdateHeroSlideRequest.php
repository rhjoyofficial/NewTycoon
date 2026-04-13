<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'type' => ['required', 'in:image,video'],
            'background' => ['nullable', 'mimes:jpg,jpeg,png,webp,mp4,mov,avi', 'max:20480'],
            'has_content' => ['boolean'],
            'content_position' => ['required_if:has_content,true', 'in:left,center,right'],

            // Bilingual fields
            'badge_en' => ['nullable', 'string', 'max:50'],
            'badge_bn' => ['nullable', 'string', 'max:50'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'title_bn' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:500'],
            'subtitle_bn' => ['nullable', 'string', 'max:500'],

            'has_cta' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];

        // CTA buttons validation ONLY when has_cta is TRUE
        if ($this->boolean('has_cta')) {
            $rules['cta_buttons'] = ['required', 'array', 'min:1', 'max:3'];
            $rules['cta_buttons.*.label_en'] = ['required', 'string', 'max:50'];
            $rules['cta_buttons.*.label_bn'] = ['nullable', 'string', 'max:50'];
            $rules['cta_buttons.*.url'] = ['required', 'string', 'max:255'];
            $rules['cta_buttons.*.style'] = ['required', 'in:primary,secondary,outline'];
        } else {
            // When CTA is disabled, make cta_buttons nullable
            $rules['cta_buttons'] = ['nullable', 'array'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Slide type is required.',
            'type.in' => 'Slide type must be image or video.',

            'background.mimes' => 'Background must be an image (JPG, JPEG, PNG, WEBP) or video (MP4, MOV, AVI).',
            'background.max' => 'Background file size cannot exceed 20MB.',

            'content_position.required_if' => 'Content position is required when content is enabled.',
            'content_position.in' => 'Content position must be left, center, or right.',

            'badge_en.max' => 'English badge cannot exceed 50 characters.',
            'badge_bn.max' => 'Bengali badge cannot exceed 50 characters.',

            'title_en.max' => 'English title cannot exceed 255 characters.',
            'title_bn.max' => 'Bengali title cannot exceed 255 characters.',

            'subtitle_en.max' => 'English subtitle cannot exceed 500 characters.',
            'subtitle_bn.max' => 'Bengali subtitle cannot exceed 500 characters.',

            'cta_buttons.required' => 'At least one CTA button is required when CTA is enabled.',
            'cta_buttons.min' => 'At least one CTA button is required.',
            'cta_buttons.max' => 'Maximum 3 CTA buttons allowed.',

            'cta_buttons.*.label_en.required' => 'English button label is required.',
            'cta_buttons.*.label_en.max' => 'English button label cannot exceed 50 characters.',
            'cta_buttons.*.label_bn.max' => 'Bengali button label cannot exceed 50 characters.',
            'cta_buttons.*.url.required' => 'Button URL is required.',
            'cta_buttons.*.url.max' => 'Button URL cannot exceed 255 characters.',
            'cta_buttons.*.style.required' => 'Button style is required.',
            'cta_buttons.*.style.in' => 'Button style must be primary, secondary, or outline.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Ensure boolean values are properly set
        $booleans = ['has_content', 'has_cta', 'is_active'];

        foreach ($booleans as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->$field, FILTER_VALIDATE_BOOLEAN),
                ]);
            } else {
                $this->merge([$field => false]);
            }
        }

        // Handle CTA buttons based on has_cta status
        if ($this->boolean('has_cta')) {
            // CTA is enabled - clean and validate buttons
            if ($this->has('cta_buttons') && is_array($this->cta_buttons)) {
                $cleanedButtons = [];

                foreach ($this->cta_buttons as $button) {
                    // Only include buttons with required fields
                    if (!empty($button['label_en']) && !empty($button['url'])) {
                        $cleanedButtons[] = [
                            'label_en' => trim($button['label_en'] ?? ''),
                            'label_bn' => trim($button['label_bn'] ?? ''),
                            'url' => trim($button['url'] ?? ''),
                            'style' => $button['style'] ?? 'primary',
                        ];
                    }
                }

                $this->merge(['cta_buttons' => $cleanedButtons]);
            } else {
                // CTA enabled but no buttons provided - set empty array (will fail validation)
                $this->merge(['cta_buttons' => []]);
            }
        } else {
            // CTA is disabled - set to null to clear existing buttons
            $this->merge(['cta_buttons' => null]);
        }
    }
}
