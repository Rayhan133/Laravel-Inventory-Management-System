@extends('layouts.theme')

@section('page_title')

@section('page_title', 'Price Update')

@section('page_index')
    <a href="{{ route('admin.dashboard') }}">Dashboard </a> &nbsp;/ Price
@endsection

@section('main_content')
    <div class="w-75 mx-auto">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Price</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('price.update', $price->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="product_id">Product <span class="text-danger">*</span></label>
                        <input type="text" name="product_id" list="product_id" required class="form-control">
                        <datalist id="product_id">
                            @foreach ($products as $product)
                                <option value="{{ $product->sku }}">{{ $product->name }}</option>
                            @endforeach
                        </datalist>
                        </input>
                        @error('product_id')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_variant">Product Variant <span class="text-danger">*</span></label>
                        <select name="product_variant" id="product_variant" required class="form-control">
                            <option value="">Select Variant</option>
                            @foreach ($products as $product)
                                @foreach ($product->sizes as $size)
                                    <option value="{{ $size }}">{{ $size }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('product_variant')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="product_price">Product Price <span class="text-danger">*</span></label>
                        <input type="number" value="{{ $price->product_price }}" name="product_price" required
                            class="form-control">
                        @error('product_price')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <!-- /.card-body -->


            </form>
        </div>
    </div>
@endsection
