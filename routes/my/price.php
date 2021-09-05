<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceController;

Route::resource('price', PriceController::class)->middleware('role:super_admin|admin|smg_manager');
