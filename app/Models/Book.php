<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author_name',
        'description',
        'price',
        'cover_image',
        'isbn',
        'published_at',
        'stock',
        'language',
        'pages',
        'is_valid',
    ];
    
}
