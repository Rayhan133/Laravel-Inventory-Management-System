@extends('layouts.theme')

@section('page_title')
    Todays Sale
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Todays Sale</a></li>
        </ol>
    </nav>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-header border-transparent bg-info">
            <h4 class="text-center">Today's Sale</h4>
        </div>
        <!-- /.card-header -->
        <div class="card-body py-3">
            <div class="table-responsive">
                <table class="table m-0 mt-5" id="example">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Total Product</th>
                            <th>Proccessed By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ route('order.show', $order->id) }}">{{ $order->order_no }}</a></td>
                                <td>{{ optional($order->customer)->name }}</td>
                                <td>{{ optional($order->orderList)->count() }}</td>
                                <td>
                                    {{ Str::ucfirst(optional($order->sales_executive)->name) }}
                                </td>
                                <td>
                                    <span class="
                                                        @switch($order->status)
                                                                                               @case('pending')
                                            badge badge-danger
                            @break
                            @case('confirmed')
                                badge badge-success
                            @break
                            @case('editable')
                                badge badge-danger
                            @break
                            @case('request-denied')
                                badge badge-danger
                            @break
                            @case('edit-request')
                                badge badge-warning text-dark
                            @break
                            @case('edited')
                                badge badge-info
                            @break
                            @default
                                badge badge-success
                        @endswitch
                        ">{{ $order->status }}</span>
                        </td>
                        <td>
                            <form action="{{ route('order.orderDestroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-info btn-sm"
                                    class="text-muted">
                                    <i class="fas fa-eye"></i>
                                </a>&nbsp;
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <a href="{{ route('order.create') }}" class="btn btn-sm btn-info float-left">Place New Order</a>
                {{-- <a href="" class="btn btn-sm btn-secondary float-right">View All Orders</a> --}}
            </div>
            <!-- /.card-footer -->
        </div>
    @endsection
