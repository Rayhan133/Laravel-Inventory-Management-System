<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['zones'] = Zone::all();
        return \view('zone.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return \view('zone.create');
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
            'name'   => 'required|string|unique:zones,name'
        ]);

        try {
            Zone::create($request->only('name'));
            Session::flash('message', 'Zone is successfully Created!');
            Session::flash('class', 'success');
            return \redirect()->route('zone.index');
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            Session::flash('class', 'danger');
            return \redirect()->route('zone.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        return \view('zone', \compact('zone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        return \view('zone.edit', \compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        Validator::make($request->all(), [
            'name'   => 'required|string,' . $zone->id
        ]);

        try {
            $zone->name = $request->input('name');
            $zone->update();
            Session::flash('message', 'Zone is successfully Updated!');
            Session::flash('class', 'success');
            return \redirect()->route('zone.index');
        } catch (Exception $e) {
            Session::flash('message', $e->getMessage());
            Session::flash('class', 'danger');
            return \redirect()->route('zone.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        Session::flash('message', 'Zone is successfully Deleted!');
        Session::flash('class', 'danger');
        return \redirect()->route('zone.index');
    }
}
