@extends('layouts.theme')

@section('page_title','Order Details')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('sales.index')}}">Sales</a></li>
        <li class="breadcrumb-item"><a>Order-details</a></li>
    </ol>
</nav>
@endsection

@section('main_content')
<orderdetails :singleorder='{{$order}}'></orderdetails>
@endsection
