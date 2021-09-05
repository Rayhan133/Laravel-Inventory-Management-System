@extends('layouts.theme')

@section('page_title', 'Total Requirements')

@section('page_index')
<nav aria-label="breadcrumb">
 <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item"><a> Total Requirements</a></li>
 </ol>
</nav>
@endsection
@section('main_content')
<requirements-list-for-purchase-team></requirements-list-for-purchase-team>
@endsection