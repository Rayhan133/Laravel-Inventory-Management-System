<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to fashol.com limited</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Google Font: Source Sans Pro -->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- lightbox  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script>
    </script>

</head>

<style>
    .card {
        margin: 20px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    span {
        font-size: 15px;
    }

    #cn {
        padding: 30px;
        display: flex;
        flex-direction: column;

    }

    #fashol {
        margin: 5px;


    }

    #trade {
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .product {
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        width: 200px;
        margin-left: 35px;

    }

    .card-title {
        margin: 15px;
    }

</style>

<body>



    <div class="container  h-100">
        <div class="row justify-content-center align-self-center">

            <div class="card" style="width: 18rem;">
                <button id="print" class="btn btn-primary"> Print</button>
            </div>
        </div>


        @foreach ($orders as $order)
            @if ($order->created_at->toDateString() === date('Y-m-d'))
                <div class="row justify-content-center align-self-center">

                    <div class="card" style="width: 18rem;">

                        <div class="card-body">

                            <h5 class="card-title"><img src="http://127.0.0.1:8000/default/fashol.png" alt="fashol.com"
                                    class="brand-image" width="170px"></h5>

                            <span id="fashol"><b>FASHOLDOTCOM LTD</b></span>
                            <div id="trade">
                                <span> Trade: 12312332</span>
                                <span>Call: +8801212121212</span>
                                <span>70, Greenroad,</span>
                                <span>Farmgate, Dhaka-1216</span>

                            </div>

                            <div id=cn>
                                <span>CN: <b>{{ $order->customer->name }}</b></span>
                                <span>A: <b>{{ $order->customer->address_line_1 }}</b></span>
                                <span>SN: <b>{{ $order->customer->store_address }}</b> </span>
                                <span>Mobile: <b>{{ $order->customer->phone }}</b> </span>
                                <span>ON: <b>{{ $order->order_no }}</b> </span>
                            </div>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($orderLists as $orderList)
                                @php
                                    if ($orderList->price != null) {
                                        if ($order->customer->account_type == 'new') {
                                            $price_type = $orderList->price->new_price;
                                        } elseif ($order->customer->account_type == 'normal') {
                                            $price_type = $orderList->price->normal_price;
                                        } else {
                                            $price_type = $orderList->price->loyal_price;
                                        }
                                    } else {
                                        $price_type = 0;
                                    }

                                @endphp
                                <div class="product">
                                    <span>{{ $sl++ }}. <b>{{ $orderList->product->name }}</b></span>
                                    <span>V: {{ $orderList->variant }} |
                                        UQ:{{ $orderList->quantity }}{{ $orderList->unite }}</span>

                                    <span>P:{{ $orderList->quantity * $price_type }}TK| <b> P:{{ $price_type }}TK.
                                            {{ $orderList->unit->unit }}</b></span>

                                </div>
                            @endforeach



                            <div class="product">

                                <span>
                                    @php
                                        $orderwithlists = $order->orderList;
                                        $countPrice = 0;
                                        $ammountPrice = 0;
                                        $getPaymentValue = 0;
                                    @endphp
                                    @foreach ($orderwithlists as $orderwithlist)

                                        @php
                                            if ($orderwithlist->price != null) {
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

                                    <b> Total: {{ number_format((float) $countPrice, 2, '.', '') }}Taka</b>

                                </span>


                            </div>

                            <div class="product">

                                <span>*Note: Call User for
                                    any query.</span>
                                <span>+8801315664544</span>
                                <span>Chalan Type: Invoice
                                    and delivery</span>
                            </div>



                        </div>

                    </div>


                </div>
            @endif
        @endforeach


    </div>



</body>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
{{-- <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/js/adminlte.min.js"></script> --}}
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="js/jquery.printPage.js"></script>
<script>
    $(document).ready(function() {
        window.resizeTo(200, 100);

        $('#print').click(function() {
            window.print();
        })

    });
</script>


</html>
