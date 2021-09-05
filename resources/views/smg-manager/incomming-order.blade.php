@extends('layouts.theme')

@section('page_title', 'Incomming Pending Orders')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a>Incomming orders</a></li>
    </ol>
</nav>
@endsection

@section('main_content')
<smg-manager-order-view-table></smg-manager-order-view-table>
@endsection
