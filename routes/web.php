<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('user.login');
});



Route::prefix('auth')->group(function () {
    Route::get('user/login', [LoginController::class, 'userLoginView'])->name('user.login');
    Route::post('user/login', [LoginController::class, 'userLoginProccess']);
});

Route::get('authenticated-user', function () {
    $user = auth()->user()->load('zone', 'addedBy');
    return response()->json([
        'status' => true,
        'message' => "You are successfully loged In",
        'data'   => $user
    ], 200);
})->middleware('role:super_admin|admin|smg_manager|sales_executive|purchases_team|root_smg_manager');

Route::get('all-user', function () {
    return User::all()->load('zone', 'addedBy');
})->middleware('role:super_admin|admin|smg_manager');

Route::get('user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware('auth');

Route::get('users/overviews', function () {
    return view('admin.user-overview');
})->name('users.overview')->middleware('role:super_admin|admin|smg_manager');
/*
* User's routes
*/
require_once('my/user.php');
/*
* Category's routes
 */
require_once('my/category.php');
/*
* Product's routes
*/
require_once('my/product.php');
/*
* Sale's routes
*/
require_once('my/sales.php');
/*
* Customer's routes
*/
require_once('my/customer.php');
/*
* Zone's routes
*/
require_once('my/zone.php');
/*
* Orders's routes
*/
require_once('my/order.php');
/*
* price's routes
*/
require_once('my/price.php');
/*
* setUnit's routes
*/
require_once('my/unit.php');
/*
* User's routes
*/
require_once('my/user.php');
/*
* Supplier's routes
*/
require_once('my/supplier.php');
/*
* Delivery routes
*/
require_once('my/delivery.php');
/*
* Account's routes
*/
require_once('my/account.php');
/*
*All the routes for smg manager's work
*/
require_once("my/smg_manager's_routes.php");
/*
* All the routes for purchase_team's work
*/
require_once("my/purchase_team's_routes.php");
/*
* All the routes for root-smg-manager work
*/
require_once("my/root_smg_manager's_routes.php");
/*
* Packaging
*/
require_once("my/packaging.php");
/*
* Chalan
*/
require_once("my/chalan.php");
