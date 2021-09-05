<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\CustomerAccountLog;
use App\Models\Customer;
use App\Models\Price;
use App\Models\Product;
use App\Models\Packaging;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Notifications\OrderCreateNotifications;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchOrders()
    {
        $orders = Order::select()->with('customer', 'sales_executive', 'orderList')->get();
        $orders = $orders->load('customer', 'sales_executive', 'orderList');
        return $this->respondWithSuccess('Orders successfully fetched!', $orders, 200);
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
        $orderNo = 'F_OR' . $randomString;
        $allOrderNo = Order::all('order_no');
        foreach ($allOrderNo as $oneOrderNo) {
            if ($oneOrderNo->order_no === $orderNo) {
                goto checkAgain;
            }
        }

        $this->data['order_no'] = $orderNo;
        return view('order.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'customer_id'   => 'required|integer',
            'order_no'      => 'required|unique:orders,order_no',
            'customer_type' => 'required',
        ]);



        if ($validate->fails()) {
            return $this->respondWithError('Something wrong!', $validate->errors(), 203);
        }

        try {
            $this->data['sales_executive_id'] = auth()->user()->id;
            $this->data['customer_id'] = $request->input('customer_id');
            $this->data['customer_type'] = $request->input('customer_type');
            $this->data['order_no'] = $request->input('order_no');
            $this->data['status'] = 'pending';

            $order = Order::create($this->data);

            $smgs = User::role('smg_manager')
                ->where('zone_id', auth()->user()->zone_id)
                ->get();

            foreach ($smgs as $smg) {
                $smg->notify(new OrderCreateNotifications($order));
            }

            $deliveryCode = random_int(0, 999999);
            $pricingBarcodeForSingle = random_int(0, 999999);
            $getQuantity = 0;
            $bakiQuantity = 7;

            $takeOne = 1;
            foreach ($request->orders as $listedOrder) {


                $list = [];
                $packaging = [];
                $list['order_id']     = $order->id;
                $list['unit_id']      = $listedOrder['unit_id'];
                $list['product_id']   = $listedOrder['product_id'];
                $list['variant']      = $listedOrder['variant'];
                $list['quantity']     = $listedOrder['quantity'];

                OrderList::create($list);


                //  Packaging Code Start
                $getQuantity = $listedOrder['quantity'];

                $value = $getQuantity / 5;
               
                if(is_float($value)){
                    $value = intval($value) +1;
                }
                
                $groupBY = 1;
                for ($i = 0; $i < $getQuantity; $i = $i + 5) {
                    $packaging['pricing_barcode'] = Str::remove('F_OR', $order->order_no) . $pricingBarcodeForSingle;
                    $oderList = OrderList::select()
                        ->orderBy('id', 'desc')
                        ->where('order_id', $order->id)->latest()->first();
                    $packaging['order_list_id']  = $oderList->id;
                    $packaging['delivery_code']   = $deliveryCode;
                    $packaging['group_by']   = $groupBY . "/" . $value;
                    if( $groupBY == $value){
                        $packaging['quantity']   = (  $getQuantity - ($groupBY* 5) == 0 ?  5 : ($getQuantity - ($groupBY-1)*5  ));
                    }else{
                        $packaging['quantity']   = 5;
                    }
                    $groupBY = $groupBY + 1;
                    Packaging::create($packaging);
                }
            }


            return $this->respondWithSuccess('Your successfully create an order');
        } catch (Exception $e) {
            return $this->respondWithError('Database errors', $e->getMessage(), 203);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::select()
            ->with('customer', 'sales_executive', 'orderList', "unit")
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->first();
        $order = $order->load('customer.zone', 'sales_executive.zone', 'orderList.product', 'orderList.unit');

        return \view('order.show', \compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('sales.index', \compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update(['status' => 'edited']);
        try {
            foreach ($request->orders as $orderedProduct) {
                $data = [
                    'unit_id'    => $orderedProduct['unit_id'],
                    'variant'    => $orderedProduct['variant'],
                    'quantity'   => $orderedProduct['quantity'],
                    'note'       => $orderedProduct['note'],
                ];
                if ($orderedProduct['id'] != null) {
                    $list = OrderList::find($orderedProduct['id']);
                    $list->update($data);
                } else {
                    $data['order_id']   = $order->id;
                    $data['product_id'] = $orderedProduct['product_id'];
                    OrderList::create($data);
                }
            }
            return $this->respondWithSuccess('Data is successfully updated!');
        } catch (Exception $e) {
            return $this->respondWithSuccess('something wents wrong!', $e->getMessage());
        }
        return $this->respondWithSuccess('Data is successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = OrderList::find($id);
        $order->delete();
        return $this->respondWithSuccess('Product is successfully removed!');
    }
    public function orderDestroy($id)
    {
        $orderNew = Order::find($id);
        $orderNew->orderList()->delete();
        $orderNew->delete();
        Session::flash('message', "Order's data is successfully Deleted!");
        Session::flash('class', "danger");
        return back();
    }

    public function pendingOrders()
    {
        $modalName = "Pending Order";
        $orders = Order::select()
            ->with('orderList')
            ->where('status', 'pending')
            ->where('sales_executive_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('sales.index', compact('orders', 'modalName'));
    }
    public function confirmOrder()
    {
        $modalName = "Confirm Order";
        $orders = Order::select()
            ->with('orderList')
            ->where('status', 'confirm')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('sales.index', compact('orders', 'modalName'));
    }
}
