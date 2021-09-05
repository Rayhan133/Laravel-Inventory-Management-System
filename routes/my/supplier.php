<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;


Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index')
    ->middleware('permission:supplier-view');
Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create')
    ->middleware('permission:supplier-create');
Route::post('supplier', [SupplierController::class, 'store'])->name('supplier.store')
    ->middleware('permission:supplier-create');
Route::get('supplier/{supplier}', [SupplierController::class, 'show'])->name('supplier.show')
    ->middleware('permission:supplier-view');
Route::get('supplier/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier.edit')
    ->middleware('permission:supplier-edit');
Route::put('supplier/{supplier}', [SupplierController::class, 'update'])->name('supplier.update')
    ->middleware('permission:supplier-edit');
Route::delete('supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy')
    ->middleware('permission:supplier-delete');
/*
* Api Routes
*/
// Route::prefix('api/supplier')->name('supplier.')->group(function () {
//     Route::get('/fetch', [SupplierController::class, 'fetchsuppliers'])->name('fetch')
//         ->middleware('permission:supplier-view');
// });
Route::get('supplier/{supplier}/status', [SupplierController::class, 'supplierStatus'])->name('supplier.status')
    ->middleware('permission:supplier-status-update');
