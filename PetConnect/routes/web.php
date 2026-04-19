<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');

    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

    Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

    Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');



    Route::get('/pets/{pet}/posts/create', [PostController::class, 'create'])
        ->name('posts.create')
        ->middleware('auth');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store')
        ->middleware('auth');

    Route::delete('/posts/{id}', [PostController::class, 'destroy'])
        ->name('posts.destroy')
        ->middleware('auth');


    Route::post('/posts/{id}/like', [PostLikeController::class, 'toggle'])
        ->name('posts.like')
        ->middleware('auth');
});


Route::get('/pets', [PetController::class, 'list'])->name('pets.list');

Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');

require __DIR__.'/auth.php';

