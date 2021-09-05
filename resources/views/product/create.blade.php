@extends('layouts.theme')

@section('page_title', 'Product-Create')

@section('page_index')
<a href="{{route('user.dashboard')}}">Dashboard </a> &nbsp;/ Product-Create
@endsection

@section('main_content')
<productcreate productsku="{{$sku}}"></productcreate>
@endsection
