<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:1',
            'categories' => 'required|array|exists:categories,id',
            'description' => 'required|string|max:5000',
            'image' => 'nullable|image|max:1024',
        ];
    }
}
