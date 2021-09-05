@extends('layouts.theme')

@section('page_title')
    Delivery Man's
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Delivery Man</a></li>
        </ol>
    </nav>
@endsection


@section('main_content')
    <a href="{{ route('delivery.create') }}">
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUnit"
            style="margin-left:90%">
            Add <i class="fa fa-plus"></i>
        </button>
    </a>
    @php
    $sl = 1;
    @endphp
    <table id="example" class="table table-bordered table-striped table-hover">
        <thead class="bg-info">
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Account Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach ($deliveries as $delivery)
            <tr>
                <td>
                    {{ $sl++ }}
                </td>
                <td>
                    <a href="{{ route('delivery.edit', $delivery->id) }}" class="">
                        {{ $delivery->name }}
                    </a>
                </td>
                <td>{{ $delivery->email }}</td>
                <td>{{ $delivery->phone }}</td>
                {{-- <th>{{ $delivery->account_status }}</th> --}}
                <td class="text-center">
                    <a href="{{ route('delivery.status', $delivery->id) }}"
                        class="{{ $delivery->account_status ? 'badge badge-success' : 'badge badge-danger' }} btn">{{ $delivery->account_status ? 'Active' : 'Inactive' }}</a>
                </td>
                <td>
                    <form action="{{ route('delivery.destroy', $delivery->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('delivery.edit', $delivery->id) }}" class="btn btn-info btn-sm"
                            class="text-muted">
                            <i class="fas fa-eye"></i>
                        </a>&nbsp;
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i
                                class="fa fa-trash-alt"></i></button>
                    </form>
                </td>

            </tr>
        @endforeach

    </table>
    </div>

@endsection
