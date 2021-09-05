<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use phpseclib3\Crypt\Random;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['products'] = Product::select()
            ->get();

        return view('product.index', $this->data);
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
        $sku = 'F_PR' . $randomString;
        $productAllSku = Product::all('sku');
        foreach ($productAllSku as $productSku) {
            if ($productSku->sku === $sku) {
                goto checkAgain;
            }
        }

        $this->data['sku'] = $sku;
        return view('product.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|unique:products,name',
            'category'       => 'required|numeric',
            'sku'            => 'required|unique:products,sku',
            'unit_id'        => 'required',
            'description'    => 'nullable|max:1000'
        ]);

        if ($validator->fails()) {
            return $this->respondWithError('Validation Errors', $validator->errors()->all(), 202);
        }

        try {
            $this->data['name']              = $request->input('name');
            $this->data['smg_manager_id']    = auth()->user()->id;
            $this->data['category_id']       = $request->input('category');
            $this->data['sku']               = $request->input('sku');
            $this->data['unit_id']           = $request->input('unit_id');
            $this->data['description']       = $request->input('description');
            $this->data['status']            = 0;

            $sizes = [];
            foreach (explode(',', $request->sizes) as $key => $size) {
                $sizes[$key] = $size;
            }
            if ($sizes[0] != "") {
                $this->data['sizes']    = $sizes;
            } else {
                $this->data['sizes']    = [];
            }

            /*             $photo = $request->file('image');

            $image_name = 'product_' . Date('d M,Y H:i:s') . '.' . $photo->extension();
            $this->data['image'] = $image_name;
            $photo->storeAs('images/', $image_name, 'public');
            */
            Product::create($this->data);
            //return $this->data;

            Session::flash('message', "\u{1F603} Product is successfully created!");
            Session::flash('class', 'success');
            return $this->respondWithSuccess('Product is successfully Created!');
        } catch (Exception $e) {
            Session::flash('message', 'Please Try again.Something went wrong!');
            Session::flash('class', 'danger');
            return $this->respondWithError('Something wents wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        /*         $this->data['product'] = $product;
        $this->data['colors'] = explode(',', $product->colors);
        $this->data['sizes'] = explode(',', $product->sizes);
        return view('product.show', $this->data); */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|unique:products,name,' . $product->id,
            'category'       => 'required|numeric',
            'sku'            => 'required|unique:products,sku,' . $product->id,
            'unit_id'        => 'required',
            'description'    => 'nullable|max:1000'
        ]);

        if ($validator->fails()) {
            return $this->respondWithError('Validation Errors', $validator->errors()->all(), 202);
        }

        try {
            $this->data['name']              = $request->input('name');
            $this->data['smg_manager_id']    = auth()->user()->id;
            $this->data['category_id']       = $request->input('category');
            $this->data['sku']               = $request->input('sku');
            $this->data['unit_id']           = $request->input('unit_id');
            $this->data['description']       = $request->input('description');
            $this->data['status']            = 0;

            $sizes = [];
            foreach (explode(',', $request->sizes) as $key => $size) {
                $sizes[$key] = $size;
            }
            if ($sizes[0] != "") {
                $this->data['sizes']    = $sizes;
            } else {
                $this->data['sizes']    = [];
            }
            /*
            if ($request->hasFile('image')) {
                Storage::delete('public/images/', $product->image);

                $photo = $request->file('image');
                $image_name = 'product_' . Date('d M,Y H:i:s') . '.' . $photo->extension();
                $this->data['image'] = $image_name;
                $photo->storeAs('images/', $image_name, 'public');
            } else {
                $this->data['image'] = $product->image;
            } */

            $product->update($this->data);

            Session::flash('message', "\u{1F603} Product's data is successfully Update!");
            Session::flash('class', 'success');
            return $this->respondWithSuccess('Product is successfully updated!');
        } catch (Exception $e) {
            Session::flash('message', 'Please Try again.Something went wrong!');
            Session::flash('class', 'danger');
            return $this->respondWithError('Something wents wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Session::flash('message', 'Product is successfully deleted!');
        Session::flash('class', 'danger');
        return redirect()->route('product.index');
    }

    public function fetchProducts()
    {
        $products = Product::all();
        return $this->respondWithSuccess('Data successfully fetched!', $products, 200);
    }
}
