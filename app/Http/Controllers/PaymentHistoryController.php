<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $Payment_history = Payment_history::all();


        return $this->respondWithSuccess('You are success', $Payment_history, 200);
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
     * @param  \App\Models\Payment_history  $payment_history
     * @return \Illuminate\Http\Response
     */
    public function show(Payment_history $payment_history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment_history  $payment_history
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment_history $payment_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment_history  $payment_history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment_history $payment_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment_history  $payment_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment_history $payment_history)
    {
        //
    }
}
