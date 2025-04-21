<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Interfaces\Book\BookInterfcace;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $book;

    public function __construct(BookInterfcace $book){
        $this->book=$book;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return  $this->book->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
