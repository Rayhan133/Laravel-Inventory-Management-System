<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


Route::resource('/category', CategoryController::class)->except(['show'])->middleware('role:super_admin|admin|smg_manager|sales_executive');

/*
* Api Routes
*/
Route::prefix('api/category')->middleware('role:super_admin|admin|smg_manager|sales_executive')->name('category.')->group(function () {
    Route::get('/fetch', [CategoryController::class, 'fetchCategory'])->name('fetch');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
});
