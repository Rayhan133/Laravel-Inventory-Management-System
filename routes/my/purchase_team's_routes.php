<?php

use App\Http\Controllers\PurchaseTeamController;
use Illuminate\Support\Facades\Route;

Route::get('my/pending-order-from-smg-manager', [PurchaseTeamController::class, 'pendingOrders'])
    ->name('purchaser.order.pending')
    ->middleware('role:purchases_team');

Route::get('my/todays-requirements/get', [PurchaseTeamController::class, 'fetchTodaysTotalRequirements'])
    ->name('purchase.todays-requirements.get')
    ->middleware('role_or_permission:purchases_team');

Route::post('my/todays-requirements/store', [PurchaseTeamController::class, 'storeFullFilledOrder'])
    ->name('purchase.todays-requirements.store')
    ->middleware('role_or_permission:purchases_team');
