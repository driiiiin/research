<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;

Route::get('/books', function () {
    return response()->json(\App\Models\Book::with('category')->get());
});
