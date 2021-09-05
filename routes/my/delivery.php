<?php

use App\Http\Controllers\DeliveryTeamController;
use Illuminate\Support\Facades\Route;



Route::get('delivery', [DeliveryTeamController::class, 'index'])->name('delivery.index');
    // ->middleware('permission:delivery-view');
Route::get('delivery/create', [DeliveryTeamController::class, 'create'])->name('delivery.create');
    // ->middleware('permission:delivery-create');
Route::post('delivery', [DeliveryTeamController::class, 'store'])->name('delivery.store');
    // ->middleware('permission:delivery-create');
Route::get('delivery/{id}/show', [DeliveryTeamController::class, 'show'])->name('delivery.show');
    // ->middleware('permission:delivery-view');
Route::get('delivery/{delivery}/edit', [DeliveryTeamController::class, 'edit'])->name('delivery.edit');
    // ->middleware('permission:delivery-edit');
Route::put('delivery/{delivery}', [DeliveryTeamController::class, 'update'])->name('delivery.update');
    // ->middleware('permission:delivery-edit');
Route::delete('delivery/{delivery}', [DeliveryTeamController::class, 'destroy'])->name('delivery.destroy');
    // ->middleware('permission:delivery-delete');
/*
* Api Routes
*/
// Route::prefix('api/supplier')->name('supplier.')->group(function () {
//     Route::get('/fetch', [DeliveryTeamController::class, 'fetchsuppliers'])->name('fetch')
//         ->middleware('permission:supplier-view');
// });
Route::get('delivery/{delivery}/status', [DeliveryTeamController::class, 'deliveryStatus'])->name('delivery.status');
Route::get('delivery/invoice', [DeliveryTeamController::class, 'deliveryInvoice'])->name('delivery.invoice');
    // ->middleware('permission:supplier-status-update');
