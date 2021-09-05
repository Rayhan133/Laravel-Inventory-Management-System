@extends('layouts.theme')

@section('page_title')
    {{ $suppliers->name }}'s Details
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
            <li class="breadcrumb-item"><a>Supplier's-details</a></li>
        </ol>
    </nav>
@endsection


@section('main_content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('default/customer.png') }}" style="height: 95px"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $suppliers->name }}</h3>

                            <p class="text-muted text-center">Supplier</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Today's Supply</b> <a class="float-right">
                                        @php
                                            $today_order = 0;
                                        @endphp
                                        {{-- @foreach ($Orders as $order)
                                            @if ($order->created_at->toDateString() === date('Y-m-d'))
                                                @if ($order->customer_id == $customer->id)
                                                    @php
                                                        $today_order++;
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach --}}
                                        {{ $today_order }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Supply</b> <a class="float-right">
                                        @php
                                            $total_order = 0;
                                        @endphp
                                        {{-- @foreach ($Orders as $order)
                                            @if ($order->customer_id == $customer->id)
                                                @php
                                                    $total_order++;
                                                @endphp
                                            @endif
                                        @endforeach --}}
                                        {{ $total_order }}
                                    </a>
                                </li>

                            </ul>

                            {{-- <a href="#"
                                class="btn btn-block {{ $suppliers->account_status ? 'btn-success' : 'btn-danger' }}"><b>{{ $customer->account_status ? 'Active' : 'Inactive' }}</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fa fa-envelope-open mr-1"></i>Email</strong>
                            <p class="text-muted">
                                {{ $suppliers->email }}
                            </p>
                            <hr>
                            <strong><i class="fa fa-phone mr-1"></i> Phone</strong>

                            <p class="text-muted">{{ $suppliers->phone }}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> City</strong>

                            <p class="text-muted">{{ $suppliers->city }}</p>
                            <hr>
                            <strong><i class="fas fa-map-marked-alt mr-1"></i> Address</strong>

                            <p class="text-muted">{{ $suppliers->address_line_1 }}</p>
                            <hr>
                            <strong><i class="fas fa-map-pin mr-1"></i> Zone</strong>

                            <p class="text-muted"> {{ $suppliers->zone->name }}</p>
                            <hr>
                            <strong><i class="fas fa fa-id-card mr-1"></i>NID Card</strong>
                            <div class="py-1">

                                <img class="border img-fluid"
                                    src="{{ $suppliers->nid_image ? asset('storage/Supplier_NID_Image/' . $suppliers->nid_image) : asset('default/nid.jpg') }}"
                                    style="width: 250px" alt="{{ $suppliers->nid_image }}">

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Today's
                                        Order</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Total Order</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Update
                                        Profile</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- /.card-header -->
                                    @php
                                        $count = 0;
                                    @endphp
                                    {{-- @foreach ($Orders as $order)
                                        @if ($order->created_at->toDateString() === date('Y-m-d'))
                                            @if ($order->customer_id == $customer->id)
                                                <span class="d-none">
                                                    {{ $count = $order->count() }}</span>
                                            @endif
                                        @endif
                                    @endforeach --}}
                                    @if ($count == 0)
                                        <h4>No Order Found</h4>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table text-center m-auto" id="example">
                                                <thead>
                                                    <tr class="bg-primary">
                                                        <th>#Sl</th>
                                                        <th>Order ID</th>
                                                        <th>Total Product</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sl = 1;
                                                    @endphp
                                                    {{-- @foreach ($Orders as $order)
                                                        @if ($order->created_at->toDateString() === date('Y-m-d'))
                                                            @if ($order->customer_id == $customer->id)
                                                                <tr>
                                                                    <td>{{ $sl++ }}</td>
                                                                    <td>
                                                                        <a href="{{ route('order.show', $order->id) }}">
                                                                            {{ $order->order_no }}
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        {{ $order->orderList->count() }}
                                                                    </td>
                                                                    <td class="text-center my-auto">
                                                                        <span
                                                                            class="{{ $order->status == 'pending' ? 'badge badge-danger' : 'badge badge-success' }}">
                                                                            {{ $order->status ? 'Pendding' : 'Confirmed' }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <form
                                                                            action="{{ route('order.orderDestroy', $order->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <a href="{{ route('order.show', $order->id) }}"
                                                                                class="btn btn-info btn-sm"
                                                                                class="text-muted">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>&nbsp;
                                                                            <button type="submit"
                                                                                onclick="return confirm('Are you sure?')"
                                                                                class="btn btn-danger btn-sm"><i
                                                                                    class="fa fa-trash-alt"></i></button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach --}}


                                                </tbody>
                                            </table>

                                            <!-- /.table-responsive -->
                                        </div>
                                    @endif
                                    <!-- /.card-body -->

                                    <!-- /.card-footer -->

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- /.card-header -->
                                    @php
                                        $count = 0;
                                    @endphp
                                    {{-- @foreach ($Orders as $order)
                                        @if ($order->customer_id == $customer->id)
                                            <span class="d-none"> {{ $count = $order->count() }}</span>
                                        @endif
                                    @endforeach --}}
                                    @if ($count == 0)
                                        <h4>No Order Found</h4>
                                        {{-- @else
                                        <div class="table-responsive">
                                            <table class="table text-center m-auto" id="example1">
                                                <thead class="bg-secondary">
                                                    <tr>
                                                        <th>#Sl</th>
                                                        <th>Order ID</th>
                                                        <th>Total Product</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sl = 1;
                                                    @endphp
                                                    @foreach ($Orders as $order)
                                                        @if ($order->customer_id == $customer->id)
                                                            <tr>
                                                                <td>{{ $sl++ }}</td>
                                                                <td>
                                                                    <a href="{{ route('order.show', $order->id) }}">
                                                                        {{ $order->order_no }}
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    {{ $order->orderList->count() }}
                                                                </td>
                                                                <td class="text-center my-auto">
                                                                    <span
                                                                        class="{{ $order->status == 'pending' ? 'badge badge-danger' : 'badge badge-success' }}">
                                                                        {{ $order->status ? 'Pendding' : 'Confirmed' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <form
                                                                        action="{{ route('order.orderDestroy', $order->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <a href="{{ route('order.show', $order->id) }}"
                                                                            class="btn btn-info btn-sm" class="text-muted">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>&nbsp;
                                                                        <button type="submit"
                                                                            onclick="return confirm('Are you sure?')"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-trash-alt"></i></button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach


                                                </tbody>
                                            </table>

                                            <!-- /.table-responsive -->
                                        </div>
                                    @endif --}}
                                    @endif
                                    <!-- /.card-body -->

                                    <!-- /.card-footer -->

                                </div>

                                <div class="tab-pane" id="settings">
                                    @include('supplier._petials.edit')
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
@endsection
