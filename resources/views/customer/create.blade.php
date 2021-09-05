@extends('layouts.theme')

@section('page_title')
Add New Customer
@endsection

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Customers</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Customer</li>
    </ol>
</nav>
@endsection

@section('main_content')
<div class="w-75 mx-auto">
    <div class="card card-primary">
        <!-- form start -->
        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h4 class="text-center">Customer ID #: {{ $unique_id }}</h4>
                <input type="hidden" value="{{ $unique_id }}" required readonly name="unique_id">
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name')
                                                is-invalid
                                @enderror" name="name" value="{{ old('name') }}" id="name" required
                        placeholder="Your full name">
                    @error('name')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Mobile Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('phone')
                                                is-invalid
                                @enderror" value="{{ old('phone') }}" name="phone" id="phone" required
                        placeholder="Mobile Number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                    @error('phone')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="address_line_1">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address_line_1')
                                                    is-invalid
                                    @enderror" value="{{ old('address_line_1') }}" name="address_line_1" required
                            id="addressLine1" placeholder="Address Line 1">
                        @error('address_line_1')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>

                   <div class="form-group col-6">
                    <label for="store_address">Store Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('store_address')
                                                        is-invalid
                                            @enderror" value="{{ old('store_address') }}" name="store_address" required
                        id="store_address" placeholder="Store Address">
                    @error('store_address')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label for="address_line_2">Address Line 2</label>
                    <input type="text" class="form-control @error('address_line_2')
                                                        is-invalid
                                            @enderror" value="{{ old('address_line_2') }}" name="address_line_2"
                        id="addressLine2" placeholder="Address Line 2">
                    @error('address_line_2')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-6">
                        <label for="zoneId">Zone <span class="text-danger">*</span></label>
                        <select name="zone_id" id="zoneId" required value="{{old('zone_id')}}" class="form-control">
                            <option value="">Select Zone</option>
                            @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                        @error('zone_id')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
               

                <div class="form-group">
                    <label for="nid_image">Nid Image upload</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('nid_image')
                                                        is-invalid
                                        @enderror" name="nid_image" id="nid_image" accept="image/*">
                            <label class="custom-file-label" for="nid_image">Choose file</label>
                        </div>
                    </div>
                    @error('nid_image')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer d-flex row">
                <div class="d-flex justify-content-start col-md-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <div class="d-flex justify-content-end col-md-6">
                    <a href="{{ route('customer.index') }}">
                        <button type="button" class="btn btn-primary">Cancel</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
