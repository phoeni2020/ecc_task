<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PharmacyController;

// Redirect the root URL to the product index page
Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class); // Use '/' to define resourceful routes properly

// Product Routes with Prefix
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('search', [ProductController::class, 'search'])->name('search'); // Normal search
    Route::get('search-ajax', [ProductController::class, 'searchAjax'])->name('search.ajax'); // AJAX search
});

// Pharmacies Routes
Route::resource('pharmacies', PharmacyController::class);
