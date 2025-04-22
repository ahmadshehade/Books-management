<?php

namespace App\Interfaces\Book;

interface BookCreationInterface
{

    public function create();

    public function store($request);
}
