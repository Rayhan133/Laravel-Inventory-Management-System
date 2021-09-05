@extends('layouts.theme')

@section('page_title')

@section('page_title', 'Unit Update')

@section('page_index')

@endsection

@section('main_content')

    <div class="w-75 mx-auto">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Unit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('setUnit.update', $setUnit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="unit">Unit <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $setUnit->unit }}" name="unit" required class="form-control">
                        @error('unit')
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
