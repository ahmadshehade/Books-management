<?php

namespace App\Providers;

use App\Interfaces\Book\BookInterfcace;
use App\Repositories\Book\BookRepository;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookInterfcace::class,BookRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
