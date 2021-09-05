@extends('layouts.theme')

@section('page_title', 'Todays Requirement')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a>Todays Requirement</a></li>
    </ol>
</nav>
@endsection

@section('main_content')
<div class="card">
    <div class="card-header border-transparent bg-info">
        <h4 class="text-center">Today's Requirements</h4>
    </div>
    <!-- /.card-header -->
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table m-0 mt-5 border table-striped" id="example">
                <thead>
                    <tr class="bg-secondary text-center">
                        <th>#Sl</th>
                        <th>Zone</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $sl = 1;
                    @endphp
                    @foreach ($zones as $zone)
                    <tr class="text-center">
                        <td>{{ $sl++ }}</td>
                        <td><a href="{{route('root-smg.todays-requirements.show',$zone->id)}}">{{ $zone->name }}</a>
                        </td>
                        <td>
                            <span
                                class="{{$zone->requirements[0]->status == "waiting" ? 'badge badge-danger' : 'badge badge-success'}}">{{$zone->requirements[0]->status}}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
</div>
@endsection