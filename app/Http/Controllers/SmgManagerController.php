<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Requirement;
use App\Notifications\orderSendToPurchaseTeamNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SmgManagerController extends Controller
{
    public function getIncommingPendingOrders()
    {
        return \view('smg-manager.incomming-order');
    }

    public function fethcIncommingPendingOrders()
    {
        $id = [];
        foreach (auth()->user()->notifications as $notification) {
            array_push($id, $notification->data['order']['id']);
        }
        $NotifiedOrder = Order::select()
            ->whereIn('id', $id)
            ->whereDay('created_at', date('d'))
            ->orderBy('updated_at', 'asc')
            ->get();
        $orders = $NotifiedOrder->load('sales_executive', 'orderList', 'customer');
        return $this->respondWithSuccess('You are success to fetch Notifications', $orders);
    }

    public function updateTheOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->input('status')]);

        Session::flash('message', 'Order is succcessfully send to parchase team');
        Session::flash('class', 'success');
        return $this->respondWithSuccess('Your successfully update your data', $order->status);
    }

    public function sendAllConfirmedOrders(Request $request)
    {
        $orders = Order::select()
            ->whereIn('id', $request->id)
            ->get();
        foreach ($orders as $order) {
            $lists = $order->orderList;
        }

        foreach ($lists as $list) {
            $requirement = Requirement::select()->where([
                ['product_id', '=', $list->product_id],
                ['variant', '=', $list->variant],
                ['zone_id', '=', auth()->user()->zone_id],
            ])->first();

            if ($requirement) {
                $requirement->required_qty = (int) $requirement->required_qty + (int) $list->quantity;
                $requirement->update();
            } else {
                $this->data['zone_id']           = auth()->user()->zone_id;
                $this->data['product_id']        = $list->product_id;
                $this->data['unit_id']           = $list->unit_id;
                $this->data['variant']           = $list->variant;
                $this->data['required_qty']      = $list->quantity;
                $this->data['status']            = 'waiting';

                $requirement = Requirement::create($this->data);
            }
        }

        $users = User::role('root_smg_manager')->get();
        foreach ($users as $user) {
            $user->notify(new orderSendToPurchaseTeamNotifications($requirement));
        }

        return $this->respondWithSuccess('Your successfully Sent To Root SMG-Manager');
    }
}
