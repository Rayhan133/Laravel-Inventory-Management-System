<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;



Route::get('product', [ProductController::class, 'index'])->name('product.index')->middleware('permission:product-view');
Route::get('product/create', [ProductController::class, 'create'])->name('product.create')->middleware('permission:product-create');
Route::get('product/{product}', [ProductController::class, 'show'])->name('product.show')->middleware('permission:product-view');
Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit')->middleware('permission:product-edit');
Route::delete('product/{product}', [ProductController::class, 'destroy'])->name('product.destroy')->middleware('permission:product-delete');


/*
* Api Routes
*/
Route::prefix('api/product')->name('product.')->group(function () {
    Route::get('/fetch', [ProductController::class, 'fetchProducts'])->name('fetch')->middleware('permission:product-view');
    Route::post('/store', [ProductController::class, 'store'])->name('store')->middleware('permission:product-create');
    Route::post('/{product}/update', [ProductController::class, 'update'])->name('update')->middleware('permission:product-edit');
});
