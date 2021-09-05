<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccountLog;
use App\Models\Customer;
use App\Models\Price;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerAccountLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerAccountLog $customerAccountLog)


    {
        // $customers = Customer::select()->where('zone_id', Auth()->user()->zone_id)->get();

        // $customerPrices = [];
        // foreach ($customers as $customer) {
        //     $orders = $customer->orders;

        //     $price = 0;
        //     foreach ($orders as $order) {


        if (User::role('super_admin')) {
            $customers = Customer::all();
        } else {
            $customers = Customer::select()->where('zone_id', Auth()->user()->zone_id)->get();
        }

        //         $orderLists =  $order->orderList;
        //         foreach($orderLists as $orderList){

        //             $price = $price + ( $orderList->quantity * Price::select()->where('product_id',$orderList->product_id)->first()->product_price);

        //         }

        //     }
        //     $customerPrice = [$customer,$price];

        //     array_push($customerPrices,$customerPrice);
        // }
        $customers = Customer::all();
        foreach ($customers as $customer) {

            $id = $customer->id;
            $accounts = CustomerAccountLog::select()->first();
            $account = CustomerAccountLog::select()->where('customer_id', $id)->first();
            if (!empty($accounts) && $account != null) {


                if ($id != $account->customer_id) {


                    $orders = $customer->orders;

                    $price = 0;
                    foreach ($orders as $order) {

                        $orderLists =  $order->orderList;
                        foreach ($orderLists as $orderList) {

                            $price = $price + ($orderList->quantity * Price::select()->where('product_id', $orderList->product_id)->first()->product_price);
                        }
                    }
                    $pendingPayment = $price;
                    $previousDue = 0;
                    $payment = 0;
                    $totaldue = 0;


                    $array = [];
                    $array['customer_id'] = $customer->id;
                    // $this->data['delivery_for_customer_id'] = 1;
                    $array['sales_executive_id'] = Auth()->user()->id;
                    $array['pendding_payment'] = $pendingPayment;
                    $array['previous_due'] = $previousDue;
                    $array['payment'] = $payment;
                    $array['total_due'] = $totaldue;
                    CustomerAccountLog::create($array);
                } else {
                    if ($id === $account->customer_id) {
                        $customer = Customer::find($id);



                        $orders = $customer->orders;

                        $price = 0;
                        foreach ($orders as $order) {

                            $orderLists =  $order->orderList;
                            foreach ($orderLists as $orderList) {

                                $price = $price + ($orderList->quantity * Price::select()->where('product_id', $orderList->product_id)->first()->product_price);
                            }
                        }
                        $pendingPayment = $price;
                        $previousDue = 0;
                        $payment = 0;
                        $totaldue = 0;


                        $array = [];
                        $array['customer_id'] = $customer->id;

                        $array['sales_executive_id'] = Auth()->user()->id;
                        $array['pendding_payment'] = $pendingPayment;
                        $array['previous_due'] = $previousDue;
                        $array['payment'] = $payment;
                        $array['total_due'] = $totaldue;

                        CustomerAccountLog::find(CustomerAccountLog::select()->where('customer_id', $id)->first()->id)->update($array);
                    }
                }
            } else {


                $orders = $customer->orders;

                $price = 0;
                foreach ($orders as $order) {

                    $orderLists =  $order->orderList;
                    foreach ($orderLists as $orderList) {

                        $price = $price + ($orderList->quantity * Price::select()->where('product_id', $orderList->product_id)->first()->product_price);
                    }
                }
                $pendingPayment = $price;
                $previousDue = 0;
                $payment = 0;
                $totaldue = 0;


                $array = [];
                $array['customer_id'] = $customer->id;
                // $this->data['delivery_for_customer_id'] = 1;
                $array['sales_executive_id'] = Auth()->user()->id;
                $array['pendding_payment'] = $pendingPayment;
                $array['previous_due'] = $previousDue;
                $array['payment'] = $payment;
                $array['total_due'] = $totaldue;
                CustomerAccountLog::create($array);
            }
        }






        $accounts = CustomerAccountLog::all();

        return view('customer.account', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'customer_id'                => 'required',
        //     'payment'                    => 'required',
        // ]);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerAccountLog  $customerAccountLog
     * @return \Illuminate\Http\Response
     */
    public function show()
    {



        //  return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerAccountLog  $customerAccountLog
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerAccountLog $customerAccountLog)
    {
        return \view('account.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerAccountLog  $customerAccountLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $customerAccountLog = CustomerAccountLog::findOrFail($id);

        // dd($request->input('payment'));
        $request->validate([
            'payment' => 'required'
        ]);
        try {

            // $customerAccountLog->sales_executive_id = Auth()->user()->id;
            $customerAccountLog = CustomerAccountLog::find($id);

            $customerAccountLog->customer_id = 1;


            $pendingPayment = $customerAccountLog->pendding_payment - (int)$request->input('payment');
            $previousDue = 0;
            $payment = (int)$request->input('payment');
            $totalDue = 0;
            $array = [];
            $array['customer_id'] = $customerAccountLog->id;
            $array['sales_executive_id'] = Auth()->user()->id;
            $array['pendding_payment'] = $pendingPayment;
            $array['previous_due'] = $previousDue;
            $array['payment'] = $payment;
            $array['total_due'] = $totalDue;


            // dd($array);
            // $customerAccountLog->update();
            CustomerAccountLog::find($id)->update($array);




            Session::flash('message', 'Account Log is successfully Updated!');
            Session::flash('class', 'success');
            return back();
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            Session::flash('class', 'danger');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerAccountLog  $customerAccountLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerAccountLog $customerAccountLog, $id)
    {
        $customerAccountLog->find($id)->delete();
        Session::flash('message', 'Account is successfully Deleted!');
        Session::flash('class', 'danger');
        return back();
    }
}
