<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChalanController;



Route::resource('chalan', ChalanController::class)->except('update', 'show', 'edit')->middleware('role:super_admin|admin|smg_manager');

Route::post('chalan/update',  [ChalanController::class, 'update'])->name('chalan.update')->middleware('role:super_admin|admin|smg_manager');
Route::get('chalan/find-order-number/{getOrderNumber}',  [ChalanController::class, 'getOrderNumber'])->name('chalan.getOrderNumber')->middleware('role:super_admin|admin|smg_manager');
Route::get('chalan/update-status/{id}',  [ChalanController::class, 'updateStatus']);