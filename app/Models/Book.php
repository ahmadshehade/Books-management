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
        'language_id',
        'pages',
        'is_valid',
        'pdf_copy',

    ];

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id','id');
    }
}
