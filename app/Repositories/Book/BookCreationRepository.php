<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookCreationInterface;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookCreationRepository implements BookCreationInterface
{

    public function create()
    {

        return view('Book.create');
    }

    public function store($request)
    {

        DB::beginTransaction();

        try {


            // حفظ الصورة إن وجدت
            $imagePath = null;
            if ($request->hasFile('cover_image')) {
                $originalFileName = $request->file('cover_image')->getClientOriginalName();
                $imagePath = $request->file('cover_image')->storeAs('cover_images', $originalFileName, 'public');
            }

            // إنشاء الكتاب
            $book = Book::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'author_name' => $request->author_name,
                'description' => $request->description,
                'price' => $request->price,
                'cover_image' => $imagePath,
                'isbn' => $request->isbn ?? null,
                'published_at' => $request->published_at ?? null,
                'stock' => $request->stock,
                'language' => $request->language,
                'pages' => $request->pages ?? null,
                'is_valid' => $request->is_valid ?? true,
            ]);

            DB::commit();

            return redirect()->route('books.index')->with('success', 'Book created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create book: ' . $e->getMessage());
        }
    }
}
