<?php

use App\Http\Controllers\RootSmgManagerController;
use Illuminate\Support\Facades\Route;

Route::get('@my/requirements', [RootSmgManagerController::class, 'todaysRequirement'])
    ->name('root-smg.requirements')
    ->middleware('role_or_permission:root_smg_manager');

Route::get('@my/requirements/{id}/show', [RootSmgManagerController::class, 'todaysRequirementShow'])
    ->name('root-smg.todays-requirements.show')
    ->middleware('role_or_permission:root_smg_manager');

Route::get('@my/todays-requirements/total', [RootSmgManagerController::class, 'todaysRequirementCount'])
    ->name('root-smg.todays-requirements.count')
    ->middleware('role_or_permission:root_smg_manager');

Route::get('@my/todays-requirements', [RootSmgManagerController::class, 'todaysTotalRequirements'])
    ->name('root-smg.todays-requirements')
    ->middleware('role_or_permission:root_smg_manager');

Route::get('@my/todays-requirements/fetch', [RootSmgManagerController::class, 'fetchTodaysTotalRequirements'])
    ->name('root-smg.todays-requirements.fetch')
    ->middleware('role_or_permission:root_smg_manager');

Route::post('@my/todays-requirements/store', [RootSmgManagerController::class, 'storeTodaysTotalRequirements'])
    ->name('root-smg.todays-requirements.store')
    ->middleware('role_or_permission:root_smg_manager');
