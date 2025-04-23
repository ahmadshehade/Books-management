<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookUpdatingInterface;
use App\Models\Book;
use App\Models\Language;
use App\Traits\FileTraits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\BookType;
class BookUpdatingRepository implements BookUpdatingInterface
{
    use FileTraits;

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $languages = Language::all();
        $types=BookType::all();
        return view('Book.edit', compact('book', 'languages','types'));
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {


            // العثور على الكتاب الموجود بناءً على الـ ID
            $book = Book::findOrFail($id);

            // حفظ الصورة الجديدة إذا تم رفعها


            $imagePath = $book->cover_image; // المسار الحالي للصورة

            if ($request->hasFile('cover_image')) {

                $this->deleteFile($imagePath);


                $imagePath = $this->uploadFile($request, 'cover_image', 'cover_image');
            }

            $pdf_path = $book->pdf_copy;
            if ($request->hasFile('pdf')) {

                $this->deleteFile($pdf_path);


                $pdf_path = $this->uploadFile($request, 'pdf', 'pdf_books');

            }


            // تحديث الكتاب
            $book->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'author_id' => auth('web')->user()->id,
                'description' => $request->description,
                'price' => $request->price,
                'cover_image' => $imagePath,
                'isbn' => $request->isbn,
                'published_at' => $request->published_at,
                'stock' => $request->stock,
                'language_id' => $request->language_id,
                'pages' => $request->pages,
                'is_valid' => $request->has('is_valid') ? 1 : 0,
                'pdf_copy' => $pdf_path,
                'type_id' => $request->type_id,
            ]);

            DB::commit();

            return redirect()->route('books.index')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }
}
