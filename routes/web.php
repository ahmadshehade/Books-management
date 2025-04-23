<?php

use App\Http\Controllers\Book\BookController;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\RedirectIfAuth;

use App\Http\Controllers\Auth\UserAuthController;


Route::redirect('/', '/login');

Route::get('/login', function () {
    return view('welcome');
})->middleware('redirect.auth')->name('loginPage');

Route::middleware('redirect.auth')->group(function () {
    Route::post('register', [UserAuthController::class, 'register'])->name('register');
    Route::post('login', [UserAuthController::class, 'login'])->name('login');
});


Route::middleware('auth:web')
    ->group(function () {

      

        Route::get('books', [BookController::class, 'index'])->name('books.index'); // عرض كل الكتب
        Route::get('books/create', [BookController::class, 'create'])->name('books.create'); // صفحة إنشاء كتاب
        Route::post('books', [BookController::class, 'store'])->name('books.store'); // حفظ الكتاب الجديد
        
        Route::get('books/{book}', [BookController::class, 'show'])->name('books.show'); // عرض تفاصيل كتاب
        
        
        Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit')->middleware( 'canModifyBook');
        Route::put('books/{book}', [BookController::class, 'update'])->name('books.update')->middleware( 'canModifyBook');
        
        
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy')->middleware( 'canModifyBook');
        

        Route::post('logout', [UserAuthController::class, 'logout'])
            ->name('logout');

    });


