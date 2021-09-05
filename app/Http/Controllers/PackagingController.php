<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packaging;
use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Support\Facades\Session;


class PackagingController extends Controller
{
    public function index()
    {

        return view("packaging.index");
    }
    public function fetchAllPackagingsData()
    {
        $packagings = Packaging::select()
            ->with("orderList", "orderList.order", "orderList.unit", "orderList.product")
            ->get();
        $packagings->load("orderList", "orderList.order", "orderList.unit", "orderList.product");

        return $this->respondWithSuccess("Fetch All Packagings Data", $packagings);
    }
    public function update()
    {

        $allPackagings = Packaging::all();
        foreach ($allPackagings as $allPackaging) {
            $allPackaging->update(['pricing_status' => '1']);
        }
        return redirect()->route("packaging.index");
    }

    public function todayInvoice()
    {
        $orderLists = OrderList::all();
        $orders = Order::all();
        return view('invoice.invoice_packaging', compact('orderLists', 'orders'));
    }

    public function print()
    {


        $packagings = Packaging::select()
            ->with("orderList", "orderList.order", "orderList.unit", "orderList.product")
            ->get();
        $flag = 0;


        $packagingBarCodes = Packaging::select()->where('pricing_status', '0')->get();

        if ($packagingBarCodes->isEmpty()) {
            return view('invoice.printbarcode', compact('packagings'));
        } else {
            Session::flash('message', 'Please generate all barcode and dc code!');
            Session::flash('class', 'danger');
            return back();
        }
    }
}
