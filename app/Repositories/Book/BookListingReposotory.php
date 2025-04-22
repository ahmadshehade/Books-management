<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookListingInterface;
use App\Models\Book;
use App\Models\Language;

class BookListingReposotory implements BookListingInterface
{


    public function index()
    {

        $books = Book::orderBy("created_at", "desc")->get();
        $languages = Language::all();

        return view('Book.index', compact("books", "languages"));

    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('Book.show', compact('book'));
    }
}
