@extends('layouts.theme')

@section('page_title','Category Create')

@section('page_index')
<a href="{{route('admin.dashboard')}}">Dashboard </a> &nbsp;/ Category
@endsection

@section('main_content')
<categorycreate></categorycreate>
@endsection
