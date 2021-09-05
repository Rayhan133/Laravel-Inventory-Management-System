<?php

namespace App\Http\Controllers;

use App\Models\Chalan;
use App\Models\Packaging;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class ChalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view("chalan.index");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrderNumber($getOrderNumber)
    {
        // dd($getOrderNumber);
        $getData = [];
        $getSecondData = [];
        // $valueData = 0;
        $packagings = Packaging::all();
        foreach ($packagings as $packaging) {
            $getData = [];
            // $valueData = $valueData + 1;
            if ($getOrderNumber === $packaging->orderList->order->order_no) {
                $getData["order_no"] = $packaging->orderList->order->order_no;
                $getData["product_name"] = $packaging->orderList->product->name;
                $getData["variant"] = $packaging->orderList->variant;
                $getData["unit"] = $packaging->orderList->unit->unit;
                $getData["quantity"] = $packaging->quantity;
                $getData["delivery_status"] = $packaging->delivery_status == 0 ? "Pending" : "Delivered";
                $getData["group_by"] = $packaging->group_by;
                $getData["delivery_code"] = $packaging->delivery_code;
                $getData["id"] = $packaging->id;
                array_push($getSecondData, $getData);
            } elseif ($getOrderNumber === $packaging->pricing_barcode) {
                $getData["order_no"] = $packaging->orderList->order->order_no;
                $getData["product_name"] = $packaging->orderList->product->name;
                $getData["variant"] = $packaging->orderList->variant;
                $getData["unit"] = $packaging->orderList->unit->unit;
                $getData["quantity"] = $packaging->quantity;
                $getData["delivery_status"] = $packaging->delivery_status == 0 ? "Pending" : "Delivered";
                $getData["group_by"] = $packaging->group_by;
                $getData["delivery_code"] = $packaging->delivery_code;
                $getData["id"] = $packaging->id;
                array_push($getSecondData, $getData);
            } else if ($getOrderNumber === Str::remove('F_OR', $packaging->orderList->order->order_no)) {
                $getData["order_no"] = $packaging->orderList->order->order_no;
                $getData["product_name"] = $packaging->orderList->product->name;
                $getData["variant"] = $packaging->orderList->variant;
                $getData["unit"] = $packaging->orderList->unit->unit;
                $getData["quantity"] = $packaging->quantity;
                $getData["delivery_status"] = $packaging->delivery_status == 0 ? "Pending" : "Delivered";
                $getData["group_by"] = $packaging->group_by;
                $getData["delivery_code"] = $packaging->delivery_code;
                $getData["id"] = $packaging->id;
                array_push($getSecondData, $getData);
            }
        }

        return $this->respondWithSuccess("Get Data", $getSecondData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function show(Chalan $chalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function edit(Chalan $chalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chalan $chalan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chalan  $chalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chalan $chalan)
    {
        //
    }

    public function updateStatus($id)
    {

        $chalan = Packaging::find($id);
        if ($chalan->delivery_status == 0) {
            $chalan->update(["delivery_status" => 1]);
        } else {
            $chalan->update(["delivery_status" => 0]);
        }
        return $this->respondWithSuccess("Get Data", $chalan);
    }
}
