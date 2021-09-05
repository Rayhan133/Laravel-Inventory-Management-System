<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Zone;
use App\Models\Payment_history;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\CustomerAccountLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['customers'] = Customer::all();
        return view('customer.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $numberCharacters = '0123456789';
        $charactersLength = strlen($numberCharacters);
        $randomString = '';
        checkAgain:
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $numberCharacters[rand(0, $charactersLength - 1)];
        }
        $unique_id = 'F_CU' . $randomString;
        $customerIDAll = Customer::all();
        foreach ($customerIDAll as $customerID) {
            if ($customerID->customer_id === $unique_id) {
                goto checkAgain;
            }
        }

        $zones = Zone::all();
        return view('customer.create', compact('zones', "unique_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'phone'                 => 'required|unique:customers,phone',
            'address_line_1'        => 'required|max:50',
            'store_address'        => 'required|max:50',
            'nid_image'             => 'nullable|image',
            'unique_id'             => 'required|string|unique:customers,unique_id',
        ]);

        try {
            $this->data['name']             = $request->input('name');
            $this->data['phone']            = $request->input('phone');
            $this->data['zone_id']          = $request->input('zone_id');
            $this->data['address_line_1']   = $request->input('address_line_1');
            $this->data['address_line_2']   = $request->input('address_line_2');
            $this->data['store_address']   = $request->input('store_address');
            $this->data['account_type']     ='new';

            $this->data['account_status']   = 0;

            $this->data['unique_id']        = $request->input('unique_id');
            // For NID Photo
            if ($request->hasFile('nid_image')) {
                $photo = $request->file('nid_image');
                $imageName = 'customer_nid_' . Date('H_M_H_s') . '.' . $photo->extension();
                $this->data['nid_image'] = $imageName;
                $photo->storeAs('Customer_NID_Image/', $imageName, 'public');
            }



            $this->data['sales_executive_id']   = 1;

            Customer::create($this->data);

            Session::flash('message', 'Customer Successfully created!');
            Session::flash('class', 'success');
            return redirect()->route('customer.index');
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            Session::flash('class', 'danger');
            return redirect()->route('customer.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)

    {

        $zones = Zone::all();
        $Orders = Order::select()
            ->orderBy('status', 'asc')
            ->get();


        $OrderLists = OrderList::all();

        $customerAccountLogs = CustomerAccountLog::all();
        $payment_historys = Payment_history::all();

        // dd($cu);



        return view('customer.show', compact('customer', 'zones', 'Orders', 'OrderLists', 'customerAccountLogs', 'payment_historys'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $zones = Zone::all();
        return \view('customer.show', \compact('customer', 'zones'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'                  => 'required',
            'phone'                 => 'required|unique:customers,phone,' . $customer->id,
            'address_line_1'        => 'required|max:50',
            'store_address'        => 'required|max:50',
            'nid_image'             => 'nullable|image',
        ]);
       
        try {

            $this->data['name']             = $request->input('name');
            $this->data['phone']            = $request->input('phone');
            $this->data['zone_id']          = $request->input('zone_id');
            $this->data['address_line_1']   = $request->input('address_line_1');
            $this->data['address_line_2']   = $request->input('address_line_2');
            $this->data['store_address']   = $request->input('store_address');
            $this->data['account_type']     ='new';



            if ($request->hasFile('nid_image')) {
                Storage::delete('public/Customer_NID_Image/' . $customer->nid_image);
                $photo                      = $request->file('nid_image');
                $imageName = 'customer_nid_' . Date('H_M_H_s') . '.' . $photo->extension();
                $this->data['nid_image']    = $imageName;
                $photo->storeAs('Customer_NID_Image/', $imageName, 'public');
            } else {
                $this->data['nid_image']    = $customer->nid_image;
            }

            $this->data['sales_executive_id']   = 1;

            $customer->update($this->data);

            Session::flash('message', 'Customer Successfully created!');
            Session::flash('class', 'success');
            return redirect()->route('customer.index');
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            Session::flash('class', 'danger');
            return redirect()->route('customer.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        Session::flash('message', "Customer's data is successfully Deleted!");
        Session::flash('class', "danger");
        return redirect()->route('customer.index');
    }

    public function orderDestroy(Request $request, Order $order)
    {

        $order->delete();
        Session::flash('message', "Order's data is successfully Deleted!");
        Session::flash('class', "danger");
        return redirect()->route('customer.index');
    }

    public function fetchCustomers()
    {
        $customers = Customer::select()
            ->with('zone')
            ->where('account_status', 1)
            ->get();
        return $this->respondWithSuccess('Data successfully fetched', $customers->load('zone'), 200);
    }



    public function customerStatus(customer $customer)
    {

        if ($customer->account_status == 0) {
            $customer->update(["account_status" => 1]);
        } else {
            $customer->update(["account_status" => 0]);
        }

        $status = $customer->account_status ? 'Activate' : 'Inactive';
        Session::flash('message', "Account is now $status");
        Session::flash('class', 'success');
        return redirect()->route('customer.index');
    }

    public function customerPayment(Request $request)
    {


        $request->validate([
            'payment'  => 'required',
            'image'  => 'required'
        ]);

        $payment_history = [];
        $CustomerAccountLogMatchID = CustomerAccountLog::select()
            ->where('order_id', $request->id)->first();

        try {
            $CustomerAccountLogMatchID = CustomerAccountLog::select()
                ->where('order_id', $request->id)->first();

            if ($CustomerAccountLogMatchID === null) {
                $this->data['order_id'] = $request->id;
                $this->data['customer_id'] = Order::find($request->id)->customer_id;
                $this->data['payment'] = $request->input('payment');

                if ($request->hasFile('image')) {
                    $photo                      = $request->file('image');
                    $imageName = 'Payment_image_' . Date('H_M_H_s') . '.' . $photo->extension();
                    $this->data['image'] = $imageName;
                    // Added New Item in Payment History
                    $payment_history['image'] = $imageName;
                    $photo->storeAs('Payment_image_', $imageName, 'public');
                }
                CustomerAccountLog::create($this->data);
                // Added New Item in Payment History
                $payment_history['customer_account_log_id'] = $request->id;
                $payment_history['customer_id'] = Order::find($request->id)->customer_id;
                $payment_history['order_id'] = $request->id;
                $payment_history['payment_history'] = $request->input('payment');
                Payment_history::create($payment_history);


                Session::flash('message', 'Payment Successfully Added!');
                Session::flash('class', 'success');
                return back();
            } else {
                $this->data['payment'] = $request->input('payment') + (int)$CustomerAccountLogMatchID->payment;
                if ($request->hasFile('image')) {
                    // Storage::delete('public/Payment_image_/' . $CustomerAccountLogMatchID->image);
                    $photo                      = $request->file('image');
                    $imageName = 'Payment_image_' . Date('H_M_H_s') . '.' . $photo->extension();
                    $this->data['image'] = $imageName;
                    // Added New Item in Payment History
                    $payment_history['image'] = $imageName;
                    $photo->storeAs('Payment_image_', $imageName, 'public');
                }


                // Added New Item in Payment History
                $payment_history['customer_account_log_id'] = $request->id;
                $payment_history['customer_id'] = Order::find($request->id)->customer_id;
                $payment_history['order_id'] = $request->id;
                $payment_history['payment_history'] = $request->input('payment');
                Payment_history::create($payment_history);


                $CustomerAccountLogMatchID->update($this->data);
                Session::flash('message', 'Payment Successfully updated!');
                Session::flash('class', 'success');
                return back();
            }
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            Session::flash('class', 'danger');
            return back();
        }
    }

    public function payment_history($id)
    {

        $payment_history = Payment_history::select()->where('order_id', $id)->get();

        return $this->respondWithSuccess('You are success', $payment_history, 200);
    }






    // public function customerOrderStatus(Customer $customer)
    // {

    //     if ($customer->account_status == 1) {
    //         $customer->update(["account_status" => 0]);
    //     } else {
    //         $customer->update(["account_status" => 1]);
    //     }

    //     $status = $customer->account_status ? 'Activate' : 'Inactive';
    //     Session::flash('message', "Account is now $status");
    //     $status == "Inactive" ?  Session::flash('class', 'danger') : Session::flash('class', 'success');

    //     return back();
    // }
}
