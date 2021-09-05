<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;



// Part Part Route For Sub users
Route::get('user/smg-managers', [UserController::class, 'smgManagerIndex'])
    ->name('user.smgManagerIndex')
    ->middleware('permission:user-view');

Route::get('user/admins', [UserController::class, 'adminsIndex'])
    ->name('user.adminsIndex')
    ->middleware('permission:user-view');

Route::get('user/sales-executive', [UserController::class, 'salesExecutiveIndex'])
    ->name('user.salesExecutiveIndex')
    ->middleware('permission:user-view');

Route::get('user/purchases-team', [UserController::class, 'purchasesTeamIndex'])
    ->name('user.purchasesTeamIndex')
    ->middleware('permission:user-view');







Route::get('/logout', [LoginController::class, 'userLogout'])->name('user.logout')->middleware('auth');
Route::get('user/{user}/status', [UserController::class, 'userStatus'])->name('user.status')->middleware('permission:user-status-update');
Route::get('user', [UserController::class, 'index'])->name('user.index')->middleware('permission:user-view');
Route::get('user/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:user-create');
Route::post('user', [UserController::class, 'store'])->name('user.store')->middleware('permission:user-create');
Route::get('user/{user}', [UserController::class, 'show'])->name('user.show')->middleware('permission:user-view');
Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:user-edit');
Route::put('user/{user}', [UserController::class, 'update'])->name('user.update')->middleware('permission:user-edit');
Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:user-delete');




// Route::get('user/smg', [UserController::class, 'index']);
// ->middleware('permission:user-view');
