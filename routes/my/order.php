<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('order', [OrderController::class, 'index'])
    ->name('order.index')
    ->middleware('permission:order-view');

Route::get('order/create', [OrderController::class, 'create'])
    ->name('order.create')
    ->middleware('permission:order-create');

Route::get('order/{order}', [OrderController::class, 'show'])
    ->name('order.show')
    ->middleware('role_or_permission:order-view|smg_manager');

Route::get('order/{order}/edit', [OrderController::class, 'edit'])
    ->name('order.edit')
    ->middleware('permission:order-edit');

Route::delete('order/{order}', [OrderController::class, 'destroy'])
    ->name('order.destroy')
    ->middleware('permission:order-delete');

Route::get('orders/pending', [OrderController::class, 'pendingOrders'])
    ->name('order.pending')
    ->middleware('role_or_permission:sales_executive|super_admin');

Route::prefix('api/order')->name('order.')->group(function () {
    Route::delete('/orderDestroy/{id}', [OrderController::class, 'orderDestroy'])
        ->name('orderDestroy')
        ->middleware('role_or_permission:sales_executive|order-delete');

    Route::get('/fetch', [OrderController::class, 'fetchOrders'])
        ->name('fetch')
        ->middleware('role_or_permission:sales_executive|order-view');

    Route::post('/store', [OrderController::class, 'store'])
        ->name('store')
        ->middleware('role_or_permission:sales_executive|super_admin|admin');

    Route::post('/{order}/update', [OrderController::class, 'update'])
        ->name('update')
        ->middleware('role_or_permission:sales_executive');
});
