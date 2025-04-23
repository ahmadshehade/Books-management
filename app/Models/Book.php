<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'author_id',
        'description',
        'price',
        'cover_image',
        'isbn',
        'published_at',
        'stock',
        'language_id',
        'type_id',
        'pages',
        'is_valid',
        'pdf_copy',


    ];

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id','id');
    }

    public function type()
    {
        return $this->belongsTo(BookType::class, 'type_id', 'id');
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    

}
