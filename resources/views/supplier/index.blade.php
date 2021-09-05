@extends('layouts.theme')

@section('page_title')
    Supplier
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Supplier</a></li>
        </ol>
    </nav>
@endsection


@section('main_content')
    <a href="{{ route('supplier.create') }}">
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
        @foreach ($suppliers as $supplier)
            <tr>
                <td>
                    {{ $sl++ }}
                </td>
                <td>
                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="">
                        {{ $supplier->name }}
                    </a>
                </td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phone }}</td>
                {{-- <th>{{ $supplier->account_status }}</th> --}}
                <td class="text-center">
                    <a href="{{ route('supplier.status', $supplier->id) }}"
                        class="{{ $supplier->account_status ? 'badge badge-success' : 'badge badge-danger' }} btn">{{ $supplier->account_status ? 'Active' : 'Inactive' }}</a>
                </td>
                <td>
                    <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-info btn-sm"
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
