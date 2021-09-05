@extends('layouts.theme')

@section('page_title')

@endsection

@section('page_index')
User
@endsection

@section('main_content')
<div class="w-75 mx-auto">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add new User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name')
                                                                                                                                                is-invalid
                                                                                @enderror" name="name" id="name"
                            placeholder="Name" required value="{{ old('name') }}">
                        @error('name')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email')
                                                                                                                                                is-invalid
                                                                                @enderror" name="email" id="email"
                            placeholder="Enter email" required value="{{ old('email') }}">
                        @error('email')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone')
                                                                                                                                                is-invalid
                                                                                @enderror" name="phone" id="phone"
                            placeholder="Phone Number" required value="{{ old('phone') }}">
                        @error('phone')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="zoneId">Zone <span class="text-danger">*</span></label>
                        <select name="zone_id" id="zone_id" required class="form-control @error('zone_id')
                                                                                                                                                is-invalid
                                                                                @enderror"
                            value="{{ old('zone_id') }}">
                            <option value="">Select Zone</option>
                            @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                        @error('zone')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="area">Area <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('area')
                                                                                                                                                is-invalid
                                                                                @enderror" name="area" id="area"
                            placeholder="Enter Area" value="{{ old('area') }}">
                        @error('area')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="city">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city')
                                                                                                                                                is-invalid
                                                                                @enderror" name="city" id="city"
                            placeholder="Enter City" value="{{ old('city') }}">
                        @error('city')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="address_line_1">Present Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address_line_1')
                                                                                                                                                is-invalid
                                                                                @enderror" name="address_line_1"
                            id="address_line_1" placeholder="Enter Present Address" required
                            value="{{ old('address_line_1') }}">
                        @error('address_line_1')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="address_line_2">Permanent Address</label>
                    <input type="text" class="form-control @error('address_line_2')
                                                                                                                                                is-invalid
                                                                                @enderror" name="address_line_2"
                        id="address_line_2" value="{{ old('address_line_2') }}" placeholder="Enter Permanent Address">
                    @error('address_line_2')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Image upload <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" required class="custom-file-input @error('image')
                            is-invalid
                            @enderror" accept="image/*" name="image" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                        @error('image')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="nid_image">Nid Image upload</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('nid_image')
                                             @enderror" name="nid_image" id="nid_image">
                            <label class="custom-file-label" for="nid_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                    @error('nid_image')
                    <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('password')
                                                                                                                                                 is-invalid
                                                                                @enderror" required name="password"
                            id="password" placeholder="Password" value="{{ old('password') }}">
                        @error('password')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_confirmation')
                                                                                                                                                is-invalid
                                                                                @enderror" name="password_confirmation"
                            id="password_confirmation" required placeholder="Retyping Password">
                        @error('password_confirmation')
                        <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-bold">Assign User Role <span class="text-danger">*</span></label>
                    <div class="form-row justify-content-between">
                        <div class="col-10">
                            @role('super_admin|admin')
                            <div class="custom-control custom-radio">
                                <input type="radio" name="role" id="admin" value="admin" checked required
                                    class="custom-control-input">
                                <label for="admin" class="custom-control-label">Admin</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" name="role" id="root_smg_manger" value="root_smg_manager" required
                                    class="custom-control-input">
                                <label for="root_smg_manger" class="custom-control-label">Root Smg Manager</label>
                            </div>
                            @endrole
                            @role('super_admin|admin|root_smg_manager')
                            <div class="custom-control custom-radio">
                                <input type="radio" name="role" id="smg_manger" value="smg_manager" required
                                    class="custom-control-input">
                                <label for="smg_manger" class="custom-control-label">Smg Manager</label>
                            </div>
                            @endrole

                            <div class="custom-control custom-radio">
                                <input type="radio" name="role" id="purchase" value="purchases_team" required
                                    class="custom-control-input">
                                <label for="purchase" class="custom-control-label">Purchases Team</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" name="role" id="saler" value="sales_executive"
                                    class="custom-control-input" required>
                                <label for="saler" class="custom-control-label">Sales Executive</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-success px-5">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
