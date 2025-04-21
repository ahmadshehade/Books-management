<?php

namespace App\Interfaces\Book;

interface BookInterfcace{

    public function index();

    public function create();

    public function store($request);

    public function show($id);

    public function edit($id);

    public function update($id,$request);

    public function destroy($id);

    
}