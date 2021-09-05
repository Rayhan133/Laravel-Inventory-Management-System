@extends('layouts.theme')

@section('page_title', 'Requirement Details')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a> Requirement Details</a></li>
    </ol>
</nav>
@endsection
@section('main_content')
<requirement-for-zone-base-table :requiredzone="{{$zone}}"></requirement-for-zone-base-table>
@endsection