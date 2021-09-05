@extends('layouts.theme')

@section('page_title')
Create A Order
@endsection

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="route('sales.index')">Sales</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create-order</li>
    </ol>
</nav>
@endsection

@section('main_content')
<ordercreate orderno="{{$order_no}}"></ordercreate>
@endsection
