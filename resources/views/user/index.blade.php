@extends('layouts.theme')

@section('page_title')
    New User
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>User</a></li>
        </ol>
    </nav>
@endsection

@section('main_content')

    <a href="{{ route('user.create') }}" class="btn btn-primary mb-2" style="margin-left:90%">
        Add <i class="fa fa-plus"></i>
    </a>

    <table id="example" class="table table-bordered table-striped table-hover">
        <thead class="bg-info">
            <tr>
                <th>#Sl</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Zone</th>
                <th>Account Status</th>
                <th>Added by</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sl = 1;
            @endphp
            @foreach ($users as $user)
                <tr>
                    <td>
                        {{ $sl++ }}
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ optional($user->zone)->name }}</td>
                    <td class="text-center">
                        @role('super_admin|admin|smg_manager')
                        <a href="{{ route('user.status', $user->id) }}"
                            class="{{ $user->account_status ? 'badge badge-success' : 'badge badge-danger' }} btn">{{ $user->account_status ? 'Active' : 'Inactive' }}</a>
                    @else
                        <span
                            class="{{ $user->account_status ? 'badge badge-success' : 'badge badge-danger' }}">{{ $user->account_status ? 'Active' : 'Inactive' }}</span>
                        @endrole
                    </td>
                    <td>
                        {{ Str::ucfirst($user->addedBy->name) }}
                    </td>
                    <td>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('user.show', $user->id) }}">
                                    <button type="button" class="btn btn-info btn-sm"><i
                                            class="fas fa-eye"></i></button></a>
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
