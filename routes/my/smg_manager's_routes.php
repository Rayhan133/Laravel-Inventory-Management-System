<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmgManagerController;

Route::get('my/incomming-order', [SmgManagerController::class, 'getIncommingPendingOrders'])
    ->name('smg.order.pending')
    ->middleware("role:smg_manager");

Route::get('my/incomming-order/fetch', [SmgManagerController::class, 'fethcIncommingPendingOrders'])
    ->name('smg.order.pending.fetch')
    ->middleware("role:smg_manager");

Route::post('my/incomming-order/{status}/status-update', [SmgManagerController::class, 'updateTheOrderStatus'])
    ->name('smg.order.status')
    ->middleware('role:smg_manager');

Route::post('my/orders/send-to-root-smg-manager', [SmgManagerController::class, 'sendAllConfirmedOrders'])
    ->name('smg.order.send-to-purchase')
    ->middleware('role:smg_manager');
