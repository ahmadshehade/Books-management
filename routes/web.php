<?php

use App\Http\Controllers\Book\BookController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserAuthController;


Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('loginPage');

       Route::post('register',[UserAuthController::class, 'register'])->name('register');
       Route::post('login',[UserAuthController::class, 'login'])->name('login');


   Route::middleware('auth:web')
   ->group(function () {

    Route::resource('books', BookController::class);

    Route::post('logout',[UserAuthController::class, 'logout'])
    ->name('logout');

       });


