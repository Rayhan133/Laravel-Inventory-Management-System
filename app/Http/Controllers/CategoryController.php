<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['categories'] = Category::all();
        return view('category.index', $this->data);
    }


    /*
    * Fetch all the data
    */

    public function fetchCategory()
    {
        $categories = Category::select('id', 'smg_manager_id', 'name')
            ->with('smgMenager')
            ->get();

        $this->data['categories'] = $categories->load('smgMenager');

        return $this->respondWithSuccess('You get all the categories', $this->data, Response::HTTP_OK);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'name'  => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            Session::flash('message', 'Category is Already Taken!');
            Session::flash('class', 'danger');
            return redirect()->route('category.index');
        }

        try {
            $data = [
                'smg_manager_id'  => auth()->user()->id,
                'name'  => $request->input('name'),
            ];
            $category = Category::create($data);
            if ($category) {
                Session::flash('message', 'Category is successfully Created!');
                Session::flash('class', 'success');
                //return $this->respondWithSuccess('Category successfully Created', $category, Response::HTTP_CREATED);
                return redirect()->route('category.index');
            }
        } catch (Exception $e) {
            //return $this->respondWithError($e->getMessage(), [], Response::HTTP_BAD_REQUEST);
            return redirect()->route('category.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.show', compact('Category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'  => 'required|unique:categories,name,' . $category->id,
        ]);

        $data = [
            'smg_manager_id'  => auth()->user()->id,
            'name'  => $request->input('name'),

        ];
        $category->update($data);

        Session::flash('message', 'Category is successfully Updated!');
        Session::flash('class', 'success');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        Category::find($category)->delete();
        Session::flash('message', 'Category is successfully Deleted!');
        Session::flash('class', 'danger');
        return redirect()->route('category.index');
    }
}
