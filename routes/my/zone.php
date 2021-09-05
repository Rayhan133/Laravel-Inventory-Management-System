<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoneController;

Route::resource('zone', ZoneController::class)->middleware('role:super_admin|admin');
