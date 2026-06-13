<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'featured' => ['boolean'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.name' => ['required_with:specifications', 'string', 'max:255'],
            'specifications.*.value' => ['required_with:specifications', 'string', 'max:255'],
        ];

        // Only require images on creation
        if ($this->isMethod('POST')) {
            $rules['images'] = ['required', 'array', 'min:1'];
            $rules['images.*'] = ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120']; // 5MB max
        } else {
            $rules['images'] = ['nullable', 'array'];
            $rules['images.*'] = ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'images.required' => 'At least one product image is required.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The image must be a file of type: jpg, jpeg, png, webp.',
            'images.*.max' => 'The image must not be larger than 5MB.',
            'specifications.*.name.required_with' => 'The specification name is required.',
            'specifications.*.value.required_with' => 'The specification value is required.',
        ];
    }
}
