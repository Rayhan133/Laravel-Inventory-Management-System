@extends('layouts.theme')

@section('page_title')

@section('page_title','Category Update')

@section('page_index')
<a href="{{route('admin.dashboard')}}">Dashboard </a> &nbsp;/ Category
@endsection

@section('main_content')
<div class="w-75 mx-auto">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Update categorie</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$category->name}}" id="name"
                        placeholder="Name">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
