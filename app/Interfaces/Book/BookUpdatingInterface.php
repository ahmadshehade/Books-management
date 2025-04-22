<?php

namespace App\Interfaces\Book;

interface BookUpdatingInterface
{

    public function edit($id);

    public function update($id, $request);
}
