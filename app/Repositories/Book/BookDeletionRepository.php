<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookDeletionInterface;
use App\Models\Book;
use App\Traits\FileTraits;
use Illuminate\Support\Facades\Storage;

class BookDeletionRepository implements BookDeletionInterface
{
    use FileTraits;

    public function destroy($id)
    {

        $book = Book::findOrFail($id);

        // حذف الصورة من التخزين إن وُجدت

        $this->deleteFile($book->cover_image);


        $this->deleteFile($book->pdf_copy);


        // حذف الكتاب من قاعدة البيانات
        $book->delete();

        return redirect()->back()->with('success', 'Successfully Deleted');
    }
}
