<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookDeletionInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookDeletionRepository implements  BookDeletionInterface
{

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // حذف الصورة من التخزين إن وُجدت
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // حذف الكتاب من قاعدة البيانات
        $book->delete();

        return redirect()->back()->with('success', 'Successfully Deleted');
    }
}
