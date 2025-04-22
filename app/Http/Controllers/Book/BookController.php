<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Interfaces\Book\BookCreationInterface;
use App\Interfaces\Book\BookUpdatingInterface;
use App\Interfaces\Book\BookDeletionInterface;
use App\Interfaces\Book\BookListingInterface;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookCreation;
    protected $bookUpdating;
    protected $bookDeletion;
    protected $bookListing;

    public function __construct(
        BookCreationInterface $bookCreation,
        BookUpdatingInterface $bookUpdating,
        BookDeletionInterface $bookDeletion,
        BookListingInterface  $bookListing
    )
    {
        $this->bookCreation = $bookCreation;
        $this->bookUpdating = $bookUpdating;
        $this->bookDeletion = $bookDeletion;
        $this->bookListing = $bookListing;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->bookListing->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->bookCreation->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        return $this->bookCreation->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->bookListing->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->bookUpdating->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, $id)
    {
        return $this->bookUpdating->update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->bookDeletion->destroy($id);
    }
}
