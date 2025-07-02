<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'country_codes' => 'required|array',
            'country_codes.*' => 'string|size:2|exists:countries,code',
        ];
    }
}
