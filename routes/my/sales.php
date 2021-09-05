<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;

Route::resource('sales', SalesController::class)->middleware('role_or_permission:order-view|sales_executive');

Route::post('order/{order}/status/update', [SalesController::class, 'sendOrderEditRequest'])
    ->name('order.edit-request')
    ->middleware('role:sales_executive');
