<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Unit $Unit)
    {
        $units = Unit::all();
        return view('unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributes =    $request->validate([
            'unit' => 'required|unique:units',
        ]);

        Unit::create($attributes);
        Session::flash('message', 'New Unit added Successfully...!!!');
        Session::flash('class', 'success');
        return redirect()->route('unit.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $Unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $Unit)
    {

        return view('unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $Unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $Unit)
    {

        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $Unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $Unit)
    {
        $attributes =    $request->validate([
            'unit' => 'required',
        ]);
        $Unit->update($attributes);
        Session::flash('message', 'Unit Updated Successfully!');
        Session::flash('class', 'success');
        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $Unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $Unit)
    {
        $Unit->delete();
        Session::flash('message', 'Unit Delete Success!');
        Session::flash('class', 'danger');
        return redirect()->route('unit.index');
    }

    public function fetchAllUnits()
    {
        $units  = Unit::all();
        return $this->respondWithSuccess('You fetch all units', $units);
    }
}
