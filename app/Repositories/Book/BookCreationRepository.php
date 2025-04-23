<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookCreationInterface;
use App\Models\Book;
use App\Models\Language;
use App\Traits\FileTraits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\BookType;

class BookCreationRepository implements BookCreationInterface
{
    use FileTraits;

    public function create()
    {
        $languages = Language::all();
        $types=BookType::all();
        

        return view('Book.create', compact('languages','types'));
    }

    public function store($request)
    {

        DB::beginTransaction();

        try {

            $imagePath = null;
            if ($request->hasFile('cover_image')) {

                $imagePath = $this->uploadFile($request, 'cover_image', 'cover_image');
            }
            $pdf_path = null;
            if ($request->hasFile('pdf')) {
                $pdf_path = $this->uploadFile($request, 'pdf', 'pdf_books');
            }


            // إنشاء الكتاب
            $book = Book::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'author_id' => auth('web')->user()->id,
                'description' => $request->description,
                'price' => $request->price,
                'cover_image' => $imagePath,
                'isbn' => $request->isbn ?? null,
                'published_at' => $request->published_at ?? null,
                'stock' => $request->stock,
                'language_id' => $request->language_id,
                'pages' => $request->pages ?? null,
                'is_valid' => $request->is_valid ?? true,
                'pdf_copy' => $pdf_path,
                'type_id' => $request->type_id,

            ]);

            DB::commit();

            return redirect()->route('books.index')->with('success', 'Book created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create book: ' . $e->getMessage());
        }
    }
}
