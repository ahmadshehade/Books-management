<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('web')->check()) {
            return redirect()->route('books.index')->with('error', 'You are already logged in!');
        }

        return $next($request);
    }
}
