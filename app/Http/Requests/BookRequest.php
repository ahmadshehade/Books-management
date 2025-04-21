<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'isbn' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'stock' => 'required|integer|min:0',
            'language' => 'required|string|max:10',
            'pages' => 'nullable|integer|min:0',
            'is_valid' => 'nullable|boolean',
        ];
    
        // شرط لتحديد هل هي عملية إنشاء أم تحديث
        if ($this->routeIs('books.store')) {
            $rules['cover_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['cover_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }
    
        return $rules;
    }
    
}
