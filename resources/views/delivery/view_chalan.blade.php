@extends('layouts.theme')

@section('page_title')
    View Chalan
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Delivery</a></li>
            <li class="breadcrumb-item"><a>View Chalan</a></li>
        </ol>
        <a href="{{ route('packaging.todayInvoice') }}" style="color:white;" target="_blank"><Button
                class="btn btn-success float-right" style="margin-top: 45px;"> Get All Invoice </Button> </a>
    </nav>
@endsection


@section('main_content')

    <!-- <a href="payment_history/2">iaushdfpoiuhdfpiufhopifg</a> -->

    <section class="content">

        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->

                <div class="table-responsive">
                    <table id="paymentTable" class="table text-center m-auto" id="example">
                        <thead>
                            <tr class="bg-primary">
                                <th>#Sl</th>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Customer Address</th>
                                <th>Customer Phone</th>
                                <th>Total Price</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($orders as $order)
                            
                                @if ($order->created_at->toDateString() === date('Y-m-d'))
                                
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>{{ $order->order_no }}</td>
                                        <td>{{ optional($order->customer)->name }}</td>
                                        <td>{{ optional($order->customer)->address_line_1 }}</td>
                                        <td>{{ optional($order->customer)->phone }}</td>

                                        <td>
                                            @php
                                                $orderwithlists = $order->orderList;
                                                $countPrice = 0;
                                                $ammountPrice = 0;
                                                $getPaymentValue = 0;
                                            @endphp
                                            @foreach ($orderwithlists as $orderwithlist)
                                                @php
                                                if( $orderwithlist->price != null){

                                                    if ($order->customer->account_type == 'new') {
                                                        $price_type = $orderwithlist->price->new_price;
                                                    } elseif ($order->customer->account_type == 'normal') {
                                                        $price_type = $orderwithlist->price->normal_price;
                                                    } else {
                                                        $price_type = $orderwithlist->price->loyal_price;
                                                    }
                                                    $countPrice = $countPrice + $price_type * $orderwithlist->quantity;


                                                }
                                                   
                                                @endphp

                                            @endforeach
                                            {{ number_format((float) $countPrice, 2, '.', '') }}
                                        </td>



                                        <td>
                                            <a href="{{ route('delivery.show', $order->id) }}" style="color:white;"
                                                target="_blank"><Button class="btn btn-primary"> Get Invoice
                                                </Button></a>
                                        </td>
                                    </tr>
                                    <tr>

                                    </tr>
                                @endif
                            @endforeach


                        </tbody>

                    </table>


                </div>

                <!-- /.col -->
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    @push('js')

        <script>
            $(document).ready(function() {







                lightbox.option({
                    'resizeDuration': 50,
                    'wrapAround': true
                })

            });
        </script>
    @endpush
@endsection
