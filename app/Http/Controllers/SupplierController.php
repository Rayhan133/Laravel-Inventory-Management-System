<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Supplier;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('supplier.index', ['suppliers' => Supplier::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $zones = Zone::all();
        return view('supplier.create', compact('zones',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function store(Request $request, Supplier $supplier)
    {
        $attributes = $request->validate([
            'purchase_team_id' => 'nullable',
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
        $attributes['purchase_team_id'] = 1;
        if ($request->hasFile('nid_image')) {
            Storage::delete('public/Supplier_NID_Image/' . $supplier->nid_image);
            $photo                      = $request->file('nid_image');
            $imageName = 'Supplier_nid_' . Date('H_M_H_s') . '.' . $photo->extension();
            $attributes['nid_image']    = $imageName;
            $photo->storeAs('Supplier_NID_Image/', $imageName, 'public');
        }
        Supplier::create($attributes);
        Session::flash('message', "Account Create Successfully");
        Session::flash('class', 'success');
        return redirect()->route('supplier.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
   
    {
        
        return view('supplier.show', ['suppliers' => $supplier], ['zones' => Zone::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suupplier  $suupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $attributes = $request->validate([
            'purchase_team_id' => 'nullable',
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
            Storage::delete('public/Supplier_NID_Image/' . $supplier->nid_image);
            $photo                      = $request->file('nid_image');
            $imageName = 'Supplier_nid_' . Date('H_M_H_s') . '.' . $photo->extension();
            $attributes['nid_image']    = $imageName;
            $photo->storeAs('Supplier_NID_Image/', $imageName, 'public');
        } else {
            $attributes['nid_image']    = $supplier->nid_image;
        }
        $supplier->update($attributes);
        Session::flash('message', "Account Update Successfully");
        Session::flash('class', 'success');
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suupplier  $suupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        Storage::delete('public/Supplier_NID_Image/' . $supplier->nid_image);
        $supplier->delete();
        Session::flash('message', "Account Delete Successfully");
        Session::flash('class', 'danger');
        return redirect()->route('supplier.index');
    }


    public function supplierStatus(Supplier $supplier)
    {
        if ($supplier->account_status == 0) {
            $supplier->update(["account_status" => 1]);
        } else {
            $supplier->update(["account_status" => 0]);
        }

        $status = $supplier->account_status ? 'Activate' : 'Inactive';
        Session::flash('message', "Account is now $status");
        Session::flash('class', 'success');
        return redirect()->route('supplier.index');
    }
}
