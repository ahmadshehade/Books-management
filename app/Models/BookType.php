<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
     protected $fillable=['name'];
     protected $table='book_types';

     public $timestamps=false;



     public function books()
     {
         return $this->hasMany(Book::class, 'type_id', 'id');
     }

}
