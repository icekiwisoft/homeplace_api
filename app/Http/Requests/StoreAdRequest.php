<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:"realestate","furniture"', // Ensure it's 0 or 1
            'price' => 'required|integer|min:1', // Positive integer
            'ad_type' => 'required|integer|in:0,1', // Ensure it's 0 or 1
            'category_id' => 'required|string', // Cannot be empty

            // Conditional rules based on type using required_if
            'bedroom' => 'required_if:type,"realestate"|integer|min:0',
            'mainroom' => 'required_if:type,"realestate"|integer|min:0',
            'toilet' => 'nullable|integer|min:0',
            'kitchen' => 'nullable|integer|min:0',
            'height' => 'required_if:type,"furniture"|integer|min:0',
            'width' => 'required_if:type,"furniture"|integer|min:0',
            'length' => 'required_if:type,"furniture"|integer|min:0',
            'weight' => 'required_if:type,"furniture"|integer|min:0',

            // Additional data constraints
            'announcer_id' => 'nullable|string', // Check if user exists (if applicable)
            'description' => 'nullable|string|max:255', // Set text length limit (if applicable)
        ];
    }
}
