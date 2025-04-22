<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookUpdatingInterface;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookUpdatingRepository implements  BookUpdatingInterface
{
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('Book.edit', compact('book'));
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
                // حذف الصورة القديمة إن وُجدت
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                // حفظ الصورة الجديدة
                $originalFileName = $request->file('cover_image')->getClientOriginalName();
                $imagePath = $request->file('cover_image')->storeAs('cover_images', $originalFileName, 'public');
            }


            // تحديث الكتاب
            $book->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'author_name' => $request->author_name,
                'description' => $request->description,
                'price' => $request->price,
                'cover_image' => $imagePath,
                'isbn' => $request->isbn,
                'published_at' => $request->published_at,
                'stock' => $request->stock,
                'language' => $request->language,
                'pages' => $request->pages,
                'is_valid' => $request->has('is_valid') ? 1 : 0,
            ]);

            DB::commit();

            return redirect()->route('books.index')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }
}
