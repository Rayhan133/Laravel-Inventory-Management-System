<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::select()
            ->whereDay('created_at', date('d'))
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('sales.index', compact('orders'));
    }

    public function sendOrderEditRequest(Request $request,  $id)
    {

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        Session::flash('message', 'You have successfully send an edit-request');
        Session::flash('class', 'success');
        return $this->respondWithSuccess('You have successfully updated your data');
    }
}
