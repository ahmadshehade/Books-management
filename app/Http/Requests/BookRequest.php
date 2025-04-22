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
            'language_id' => 'required|int|exists:languages,id',
            'pages' => 'nullable|integer|min:0',
            'is_valid' => 'nullable|boolean',
        ];

        // شرط لتحديد هل هي عملية إنشاء أم تحديث
        if ($this->routeIs('books.store')) {
            // قواعد للتحقق عند الإنشاء
            $rules['cover_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';  // صورة غلاف الكتاب
            $rules['pdf'] = 'required|file|mimes:pdf|max:10240';  // رفع PDF بحد أقصى 10 ميجابايت
        } else {
            // قواعد للتحقق عند التحديث
            $rules['cover_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';  // صورة غلاف الكتاب
            $rules['pdf'] = 'nullable|file|mimes:pdf|max:10240';  // رفع PDF بحد أقصى 10 ميجابايت
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',

            'author_name.required' => 'The author name is required.',
            'author_name.string' => 'The author name must be a string.',
            'author_name.max' => 'The author name may not be greater than 255 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',

            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a numeric value.',

            'isbn.string' => 'The ISBN must be a string.',
            'isbn.max' => 'The ISBN may not be greater than 255 characters.',

            'published_at.date' => 'The publication date must be a valid date.',

            'stock.required' => 'The stock field is required.',
            'stock.integer' => 'The stock must be an integer.',
            'stock.min' => 'The stock may not be less than 0.',

            'language_id.required' => 'The language is required.',
            'language_id.int' => 'The language ID must be an integer.',
            'language_id.exists' => 'The selected language does not exist.',

            'pages.integer' => 'The number of pages must be an integer.',
            'pages.min' => 'The number of pages may not be less than 0.',

            'is_valid.boolean' => 'The valid field must be true or false.',

            'cover_image.required' => 'The cover image is required.',
            'cover_image.image' => 'The cover image must be an image.',
            'cover_image.mimes' => 'The cover image must be a file of type: jpeg, png, jpg, gif.',
            'cover_image.max' => 'The cover image may not be greater than 2MB.',

            'pdf.required' => 'The PDF file is required.',
            'pdf.file' => 'The PDF must be a file.',
            'pdf.mimes' => 'The PDF must be of type: pdf.',
            'pdf.max' => 'The PDF file may not be greater than 10MB.',
        ];
    }
}
