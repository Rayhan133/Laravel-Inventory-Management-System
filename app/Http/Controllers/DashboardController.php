<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todaysOrder = Order::select()->where('updated_at', 'like', date('Y-m-d') . "%")->get();
        $orders = Order::all();
        $products = Product::all();
        $customers = Customer::all();
        return view('admin.mydashboard', compact('todaysOrder', 'orders', 'products', 'customers'));
    }
}
