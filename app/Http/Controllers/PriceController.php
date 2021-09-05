<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        $prices = Price::all();

        return view('price.index', \compact('products', 'prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $products = Product::all();
        $categories = Category::all();

        return \view('price.create', \compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, price $price)
    {
       

        $data = Product::where('sku', $request->product_id)->first();
        $attributes =    $request->validate([
            'product_id' => 'required',
            'product_variant' => 'required',
            'product_sku' => 'nullable',
            'purchase_price' => 'required',
            'new_price' => 'required',
            'normal_price' => 'required',
            'loyal_price' => 'required'

        ]);
        $attributes['product_sku'] =   $request->product_id;
        $attributes['product_id'] = $data->id;

        $var =  DB::table('prices')
            ->where('product_sku', $request->product_id)
            ->where('product_variant', $request->product_variant)->value('product_sku');

        if ($var === $request->product_id) {
            DB::table('prices')
                ->where('product_sku', $request->product_id)
                ->where('product_variant', $request->product_variant)
                ->update(
                    ['purchase_price' => $request->purchase_price,
                    'new_price' => $request->new_price,
                    'normal_price' => $request->normal_price,
                    'loyal_price' => $request->loyal_price],
                   
            
                );
            Session::flash('message', 'Update is successfully...!!!');
            Session::flash('class', 'success');
        } else {
            Price::create($attributes);
            Session::flash('message', 'New Price added Successfully...!!!');
            Session::flash('class', 'success');
        }
        return redirect()->route('price.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\price  $price
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $priceDetails = Product::where('id', $id)->first();

        return $this->respondWithSuccess('You are success', $priceDetails, 200);
        //return view('price.show', \compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $priceDetails = Price::select()->with('product')->where('id', $id)->first();

        return $this->respondWithSuccess('You are success', $priceDetails, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, price $price)
    {

        //$data = Product::where('sku', $request->product_id)->first();

        $attributes =    $request->validate([
            //'product_id' => 'required',
            'product_variant' => 'required',
            'purchase_price' => 'required',
            'new_price' => 'required',
            'normal_price' => 'required',
            'loyal_price' => 'required',
        ]);
        /// dd($attributes);
        // $attributes['product_id'] = $data->id;


        $price->update($attributes);
        Session::flash('message', 'Price Updated Successfully!');
        Session::flash('class', 'success');
        return redirect()->route('price.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(price $price)
    {
        $price->delete();
        Session::flash('message', 'Price delete success!');
        Session::flash('class', 'danger');
        return redirect('/price');
    }
}
