<?php

namespace App\Providers;


use App\Interfaces\Book\BookCreationInterface;
use App\Interfaces\Book\BookDeletionInterface;
use App\Interfaces\Book\BookListingInterface;
use App\Interfaces\Book\BookUpdatingInterface;
use App\Repositories\Book\BookCreationRepository;
use App\Repositories\Book\BookDeletionRepository;
use App\Repositories\Book\BookListingReposotory;
use App\Repositories\Book\BookUpdatingRepository;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookListingInterface::class,BookListingReposotory::class);
        $this->app->bind(BookDeletionInterface::class,BookDeletionRepository::class);
        $this->app->bind(BookUpdatingInterface::class,BookUpdatingRepository::class);
        $this->app->bind(BookCreationInterface::class,BookCreationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
