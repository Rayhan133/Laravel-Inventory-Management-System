@extends('layouts.theme')

@section('page_title', 'Customers')

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Customers</a></li>
        </ol>
    </nav>
@endsection

@section('main_content')
    <a href="{{ route('customer.create') }}">
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUnit"
            style="margin-left:90%">
            Add <i class="fa fa-plus"></i>
        </button>
    </a>


    <table id="example" class="table table-bordered table-striped table-hover">
        <thead class="bg-info">
            <tr>
                <th>#ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Zone</th>
                <th>Account Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->unique_id }}</td>
                <td>
                    <a href="{{ route('customer.show', $customer->id) }}" class="">
                        {{ Str::ucfirst(Str::upper($customer->name)) }}
                    </a>
                </td>
                <td>{{ $customer->phone }}</td>
                <td>{{ optional($customer->zone)->name }}</td>
                <td class="text-center">
                    @role('super_admin|admin|smg_manager')
                    <a href="{{ route('customer.status', $customer->id) }}"
                        class="{{ $customer->account_status ? 'badge badge-success' : 'badge badge-danger' }} btn">{{ $customer->account_status ? 'Active' : 'Inactive' }}</a>
                @else
                    <span
                        class="{{ $customer->account_status ? 'badge badge-success' : 'badge badge-danger' }}">{{ $customer->account_status ? 'Active' : 'Inactive' }}</span>
                    @endrole
                </td>


                <td>
                    <form action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-info btn-sm"
                            class="text-muted">
                            <i class="fas fa-eye"></i>
                        </a>&nbsp;
                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i
                                class="fa fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
