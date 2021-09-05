@extends('layouts.theme')

@section('page_title', 'Product-update')

@section('page_index')
    <a href="{{ route('user.dashboard') }}">Dashboard </a> &nbsp;/ Product-update
@endsection

@section('main_content')
    <productedit :product="{{ $product }}"></productedit>
@endsection
