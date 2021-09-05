<?php

namespace App\Http\Controllers;
use App\Models\DeliveryTeam;
use App\Models\Zone;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DeliveryTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('delivery.index', ['deliveries' => DeliveryTeam::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('delivery.create', compact('zones',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DeliveryTeam $deliveryTeam)
    {
        $attributes = $request->validate([
            'smg_manager_id	' => 'nullable',
            'name' => 'required',
            'email' => 'required|unique:suppliers',
            'phone' => 'required|unique:suppliers',
            'nid_image' => 'nullable',
            'zone_id' => 'nullable',
            'city' => 'required',
            'area' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            // 'password' => 'required|confirmed',
        ]);

        //$attributes['admin_id'] = Auth::id();
        $attributes['smg_manager_id'] = 1;
        if ($request->hasFile('nid_image')) {
            Storage::delete('public/Delivery_NID_Image/' . $deliveryTeam->nid_image);
            $photo                      = $request->file('nid_image');
            $imageName = 'Delivery_nid_' . Date('H_M_H_s') . '.' . $photo->extension();
            $attributes['nid_image']    = $imageName;
            $photo->storeAs('Delivery_NID_Image/', $imageName, 'public');
        }
        DeliveryTeam::create($attributes);
        Session::flash('message', "Account Create Successfully");
        Session::flash('class', 'success');
        return redirect()->route('delivery.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $orderLists = $order->orderList;
      
        return view('invoice.invoice',compact('orderLists','order'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deliveryTeam = DeliveryTeam::find($id);
        //dd($deliveryTeam);
        return view('delivery.show', ['deliveryTeam' => $deliveryTeam], ['zones' => Zone::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $deliveryMan= DeliveryTeam::find($id);
        $attributes = $request->validate([
            'smg_manager_id' => 'nullable',
            'name' => 'required',
            'email' => 'required|',
            'phone' => 'required|',
            'nid_image' => 'nullable',
            'zone_id' => 'nullable',
            'city' => 'required',
            'area' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'required',
            // 'password' => 'required|confirmed',
        ]);
        if ($request->hasFile('nid_image')) {
            Storage::delete('public/Delivery_NID_Image/' . $deliveryMan->nid_image);
            $photo                      = $request->file('nid_image');
            $imageName = 'Delivery_nid_' . Date('H_M_H_s') . '.' . $photo->extension();
            $attributes['nid_image']    = $imageName;
            $photo->storeAs('Delivery_NID_Image/', $imageName, 'public');
        } else {
            $attributes['nid_image']    = $deliveryMan->nid_image;
        }
        $deliveryMan->update($attributes);
        Session::flash('message', "Account Update Successfully");
        Session::flash('class', 'success');
        return redirect()->route('delivery.index');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deliveryMan = DeliveryTeam::find($id);
        Storage::delete('public/Delivery_NID_Image/' . $deliveryMan->nid_image);
        $deliveryMan->delete();
        Session::flash('message', "Account Delete Successfully");
        Session::flash('class', 'danger');
        return redirect()->route('delivery.index');
    }

    public function deliveryStatus($id)
    
   
    {
       
        $deliveryTeam = DeliveryTeam::find($id);
        if ($deliveryTeam->account_status == 0) {
            $deliveryTeam->update(["account_status" => 1]);
        } else {
            $deliveryTeam->update(["account_status" => 0]);
        }

        $status = $deliveryTeam->account_status ? 'Activate' : 'Inactive';
        Session::flash('message', "Account is now $status");
        Session::flash('class', 'success');
        return redirect()->route('delivery.index');
    }

    public function deliveryInvoice(){
        dd( intval(5));
        $OrderLists = OrderList::all();
        $orders = Order::select()->orderBy('id', 'desc')->get();
        
        return view('delivery.view_chalan',compact('orders','OrderLists'));
    }

}
