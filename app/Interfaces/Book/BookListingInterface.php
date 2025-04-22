<?php

namespace App\Interfaces\Book;

interface BookListingInterface
{
    public function index();

    public function show($id);
}
