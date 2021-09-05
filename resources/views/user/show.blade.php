@extends('layouts.theme')

@section('page_title')
    {{ $user->name }}'s Details
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="">User</a></li>
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

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>
                            <p class="text-muted text-center">
                                @if (Str::ucfirst($user->getRoleNames()[0]) == 'Smg_manager')
                                    SMG Manager
                                @elseif (Str::ucfirst($user->getRoleNames()[0]) == 'Purchases_team')
                                    Purchases Team
                                @else
                                    {{ Str::ucfirst($user->getRoleNames()[0]) }}
                                @endif
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Today's order</b>
                                    @php($today = 0)
                                    @foreach ($orders as $order)
                                        @if ($order->created_at->toDateString() === date('Y-m-d'))
                                            @php($today++)
                                        @endif
                                    @endforeach
                                    <a class="float-right">{{ $today }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total order</b> <a class="float-right">{{ $orders->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total-Sale</b> <a class="float-right">0 BDT</a>
                                </li>
                            </ul>


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
                            <strong><i class="fas fa-envelope-square"></i> Email:</strong>

                            <p class="text-muted">
                                {{ $user->email }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-phone-alt"></i> Phone Number:</strong>

                            <p class="text-muted">{{ $user->phone }}</p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Zone:</strong>

                            <p class="text-muted">{{ $user->zone->name }}</p>

                            <hr>

                            <strong><i class="fas fa-chart-area"></i> Area:</strong>

                            <p class="text-muted">{{ $user->area }}</p>

                            <hr>

                            <strong><i class="fas fa-map-marked-alt"></i> Address:</strong>

                            <p class="text-muted">{{ $user->address_line_1 }}</p>

                            <hr>

                            <strong><i class="far fa-eye"></i> Status:</strong>


                            @if ($user->account_status)
                                <p class="badge badge-success">Active</p>
                            @else
                                <p class="badge badge-danger">Inactive</p>

                            @endif


                            <hr>
                            <strong><i class="fas fa fa-id-card mr-1"></i>NID Card</strong>
                            <div class="py-1">
                                <img class="border img-fluid"
                                    src="{{ $user->nid_image ? asset('storage/NID_Image/' . $user->nid_image) : asset('default/nid.jpg') }}"
                                    style="width: 250px" alt="{{ $user->nid_image }}">
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
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- <p class="text-center text-danger">No order found</p> -->
                                    @include('user._petials.todayorder')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- <p class="text-center text-danger">No Order Found</p> -->
                                    @include('user._petials.totalorder')
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    @include('user._petials.edit')
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection
