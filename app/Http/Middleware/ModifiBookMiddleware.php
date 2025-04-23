<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Book;
class ModifiBookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $book_id=$request->route('book');
        $book=Book::find($book_id);
        
        if ( $book && $book->author_id == auth('web')->user()->id) {
            return $next($request);
        }
        return back()->with('error', 'You are not allowed to modify this book!');
    }
}
