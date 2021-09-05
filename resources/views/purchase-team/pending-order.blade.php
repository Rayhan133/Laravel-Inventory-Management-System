@extends('layouts.theme')

@section('page_title', 'Todays Pending Orders')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a>Todays Requirements</a></li>
    </ol>
</nav>
@endsection

@section('main_content')
<purchase-team-orders-requirements></purchase-team-orders-requirements>
@endsection