<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;

Route::resource('unit', UnitController::class)->middleware('role:super_admin|admin|smg_manager');

Route::get('units', [UnitController::class, 'fetchAllUnits'])
    ->name('unit.all')
    ->middleware('role:super_admin|admin|smg_manager|root_smg_manager|sales_executive');
