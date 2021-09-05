<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackagingController;


Route::resource('packaging', PackagingController::class)->except('update', 'show', 'edit')->middleware('role:super_admin|admin|smg_manager');

Route::post('packaging/update',  [PackagingController::class, 'update'])->name('packaging.update')->middleware('role:super_admin|admin|smg_manager');
Route::post('packaging/print',  [PackagingController::class, 'print'])->name('packaging.print');

Route::get('packaging/fetch-all-data',  [PackagingController::class, 'fetchAllPackagingsData'])->name('packaging.fetchAllPackagingsData')->middleware('role:super_admin|admin|smg_manager');
Route::get('packaging/today-invoice',  [PackagingController::class, 'todayInvoice'])->name('packaging.todayInvoice')->middleware('role:super_admin|admin|smg_manager');
