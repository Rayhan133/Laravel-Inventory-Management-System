<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentHistoryController;

// Route::resource('customer', CustomerController::class)->middleware('permission:customer-create');

Route::get('customer', [CustomerController::class, 'index'])->name('customer.index')->middleware('permission:customer-view');
Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create')->middleware('permission:customer-create');
Route::post('customer', [CustomerController::class, 'store'])->name('customer.store')->middleware('permission:customer-create');
Route::get('customer/{customer}', [CustomerController::class, 'show'])->name('customer.show')->middleware('permission:customer-view');
Route::get('customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit')->middleware('permission:customer-edit');
Route::put('customer/{customer}', [CustomerController::class, 'update'])->name('customer.update')->middleware('permission:customer-edit');
Route::delete('customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy')->middleware('permission:customer-delete');
/*
* Api Routes
*/
Route::prefix('api/customer')->name('customer.')->group(function () {
    Route::get('/fetch', [CustomerController::class, 'fetchCustomers'])->name('fetch')->middleware('permission:customer-view');
});
Route::get('customer/{customer}/status', [CustomerController::class, 'customerStatus'])->name('customer.status')->middleware('permission:customer-status-update');
Route::post('customer/{id}/payment', [CustomerController::class, 'customerPayment'])->name('customer.payment');
Route::get('customer/payment_history/{id}', [CustomerController::class, 'payment_history']);
