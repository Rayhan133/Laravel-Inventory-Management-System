<div class="w-100 mx-auto">
    <div class="card card-primary">
        <!-- form start -->
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name')
                                                            is-invalid
                    @enderror" name="name" id="name" placeholder="Name" required value="{{ $user->name }}">
                        @error('name')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email')
                                                            is-invalid
                    @enderror" name="email" id="email" placeholder="Enter email" required value="{{ $user->email }}">
                        @error('email')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control @error('phone')
                                                            is-invalid
                    @enderror" name="phone" id="phone" placeholder="Phone Number" required
                            value="{{ $user->phone }}">
                        @error('phone')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="zoneId">Zone</label>
                        <select name="zone_id" id="zone_id" value="{{ $user->zone_id }}" required
                            class="form-control">
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
                        <label for="area">Area</label>
                        <input type="text" class="form-control @error('area')
                                                            is-invalid
                    @enderror" name="area" id="area" placeholder="Enter Area" value="{{ $user->area }}">
                        @error('area')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="city">City</label>
                        <input type="text" class="form-control @error('city')
                                                            is-invalid
                    @enderror" name="city" id="city" placeholder="Enter City" value="{{ $user->city }}">
                        @error('city')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-4">
                        <label for="address_line_1">Present Address </label>
                        <input type="text" class="form-control @error('address_line_1')
                                                            is-invalid
                    @enderror" name="address_line_1" id="address_line_1" placeholder="Enter Present Address" required
                            value="{{ $user->address_line_1 }}">
                        @error('address_line_1')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="address_line_2">Permanent Address</label>
                    <input type="text" class="form-control @error('address_line_2')
                                                            is-invalid
                    @enderror" name="address_line_2" id="address_line_2" value="{{ $user->address_line_2 }}"
                        placeholder="Enter Permanent Address">
                    @error('address_line_2')
                        <div class="text-danger font-italic">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">

                    <label for="image">Image upload</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" value="{{ old('image') }}" class="custom-file-input" name="image"
                                id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <label for="nid_image">Nid Image upload</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="nid_image" id="nid_image"
                                value="{{ old('nid_image') }}">
                            <label class="custom-file-label" for="nid_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="password">New Password <small>(Optional)</small></label>
                        <input type="text" class="form-control @error('password') is-invalid
                    @enderror" name="password" id="password" placeholder="New Password">
                        @error('password')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="password_confirmation">Confirm Password <small>(Optional)</small></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid
                    @enderror" name="password_confirmation" id="password_confirmation"
                            placeholder="Confirm New Password">
                        @error('password_confirmation')
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
                        <a href="{{ route('user.index') }}">
                            <button type="button" class="btn btn-primary">Cancel</button>
                        </a>
                    </div>
                </div>
        </form>
    </div>
</div>
