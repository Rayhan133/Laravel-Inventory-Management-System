<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Zone;
use App\Models\UserDetail;
use App\Models\Order;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select()
            ->whereKeyNot(auth()->user()->id)
            ->whereKeyNot(1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.index', compact('users'));
    }

    public function adminsIndex()
    {
        if (auth()->user()->id === 1) {
            $users = User::role('admin')
                ->whereKeyNot(auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $users = User::role('admin')
                ->whereKeyNot(auth()->user()->id)
                ->where('zone_id', auth()->user()->zone_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('user.index', compact('users'));
    }
    public function smgManagerIndex()
    {

        if (auth()->user()->id === 1) {
            $users = User::role('smg_manager')
                ->whereKeyNot(auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $users = User::role('smg_manager')
                ->whereKeyNot(auth()->user()->id)
                ->where('zone_id', auth()->user()->zone_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        return view('user.index', compact('users'));
    }
    public function salesExecutiveIndex()
    {
        if (auth()->user()->id === 1) {
            $users = User::role('sales_executive')
                ->whereKeyNot(auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $users = User::role('sales_executive')
                ->whereKeyNot(auth()->user()->id)
                ->where('zone_id', auth()->user()->zone_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('user.index', compact('users'));
    }

    public function purchasesTeamIndex()
    {
        if (auth()->user()->id === 1) {
            $users = User::role('purchases_team')
                ->whereKeyNot(auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $users = User::role('purchases_team')
                ->whereKeyNot(auth()->user()->id)
                ->where('zone_id', auth()->user()->zone_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('user.create', ['zones' => $zones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'admin_id'         => 'nullable',
            'name'             => 'required',
            'email'            => 'required|unique:users',
            'phone'            => 'required|unique:users',
            'nid_image'        => 'nullable',
            'image'            => 'required|image',
            'zone_id'          => 'required',
            'password'         => 'required|confirmed',
            'address_line_1'   => 'required',
            'address_line_2'   => 'nullable',
            'area'             => 'required',
            'city'             => 'required'
        ]);
        $attributes['password']         = Hash::make($attributes['password']);
        $attributes['account_status']   = 0;
        $attributes['added_by']         = auth()->user()->id;
        // For personal Photo
        $photo               = $request->file('image');
        $imageName           = 'user_' . Date('H_M_H_s') . '.' . $photo->extension();
        $attributes['image'] = $imageName;
        $photo->storeAs('images/', $imageName, 'public');

        // For NID Photo
        if ($request->hasFile('nid_image')) {
            $photo = $request->file('nid_image');
            $imageName               = 'userNID_' . Date('H_M_H_s') . '.' . $photo->extension();
            $attributes['nid_image'] = $imageName;
            $photo->storeAs('NID_Image/', $imageName, 'public');
        }
        $user = User::create($attributes);
        $user->assignRole($request->input('role'));

        Session::flash('message', 'User Account Create success');
        Session::flash('class', 'success');
        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {

        // return view('user.show')->with('user', $user)->with('zones', Zone::all());
        $orders = Order::where('sales_executive_id', auth()->user()->id)->get();
        // dd($orders);
        return view('user.show')->with('user', $user)->with('zones', Zone::all())->with('orders', $orders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user, $id)
    {
        return view('user.show')->with('user', $user->find($id))->with('zones', Zone::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'phone' => 'required|unique:users,phone,' . $user->id,
            'password' => 'confirmed',
            'address_line_1' => 'required',
        ]);

        $this->data['added_by'] = auth()->user()->id;
        $this->data['name']             = $request->input('name');
        $this->data['email']            = $request->input('email');
        $this->data['password']         = $request->input('password') == null ? $user->password : Hash::make($request->input('password'));
        $this->data['phone']            = $request->input('phone');
        $this->data['zone_id']          = $request->input('zone_id');
        $this->data['address_line_1']   = $request->input('address_line_1');
        $this->data['address_line_2']   = $request->input('address_line_2');
        $this->data['area']             = $request->input('area');
        $this->data['city']             = $request->input('city');

        if ($request->hasFile('image')) {
            Storage::delete('public/images/', $user->image);
            $photo                  = $request->file('image');
            $imageName = 'userNID_' . Date('H_M_H_s') . '.' . $photo->extension();
            $this->data['image']    = $imageName;
            $photo->storeAs('images/', $imageName, 'public');
        } else {
            $this->data['image']    = $user->image;
        }

        if ($request->hasFile('nid_image')) {
            Storage::delete('public/NID_Image/', $user->nid_image);
            $photo                      = $request->file('nid_image');
            $imageName                  = 'userNID_' . Date('H_M_H_s') . '.' . $photo->extension();
            $this->data['nid_image']    = $imageName;
            $photo->storeAs('NID_Image/', $imageName, 'public');
        } else {
            $this->data['nid_image']    = $user->nid_image;
        }
        $this->data['admin_id']         = auth()->user()->id;

        $user->update($this->data);
        Session::flash('message', 'User Update Successfully created!');
        Session::flash('class', 'success');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        if ((int)$user->id !== (int) 1 && (int) $user->id !== (int) auth()->user()->id) {
            $user->delete();
            Session::flash('message', 'User Account Delete Successfully!');
            Session::flash('class', 'danger');
            return redirect()->route('user.index');
        } else {
            Session::flash('message', 'Sorry, You are unable to change the status!!!');
            Session::flash('class', 'danger');
            return redirect()->route('user.index');
        }
    }

    public function userStatus(user $user)
    {
        if ((int)$user->id !== (int) 1 && (int) $user->id !== (int) auth()->user()->id) {
            if ($user->account_status == 1) {
                $user->update(["account_status" => 0]);
            } else {
                $user->update(["account_status" => 1]);
            }
        } else {
            Session::flash('message', 'Sorry, you can\'t change this status!');
            Session::flash('class', 'danger');
            return redirect()->route('user.index');
        }

        $status = $user->account_status ? 'Activate' : 'Inactive';
        Session::flash('message', "Account is now $status");
        Session::flash('class', 'success');
        return back();
    }
}
