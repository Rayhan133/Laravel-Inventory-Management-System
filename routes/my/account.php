<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerAccountLogController;

// Route::resource('customer', CustomerController::class)->middleware('permission:customer-create');

Route::resource('account', CustomerAccountLogController::class);
