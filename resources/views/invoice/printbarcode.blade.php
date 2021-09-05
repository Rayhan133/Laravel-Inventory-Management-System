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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Miriam+Libre:wght@400;700&display=swap" rel="stylesheet">
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
    .fontSize {
        font-size: 8px !important;
        margin: 0 !important;
        padding: 0 !important;
        font-family: 'Miriam Libre', sans-serif;
    }

    .card {
        padding: 0 !important;
    }

    svg {
        width: fit-content !important;
        height: 35px !important;
    }

    #barcode {
        float: left;
        padding: 0 !important;
        margin: 0 !important;
    }

    #dccode {
        padding: 0 !important;
        margin: 0 !important;
    }

</style>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.4/JsBarcode.all.min.js"
integrity="sha512-9KXy/GLQQ+pPW7VwnI74DzjzUix9GINtAAPwWl4vzaaEqgfOeDgkea6UWM4xAvCeoeiBxzYepep2xxbkX3w/pg=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>

    <div class="container  h-100">
        <div class="row justify-content-center align-self-center mt-3">
            <div class="card" style="width: 18rem;">
                <button id="print" class="btn btn-primary">Print</button>
            </div>
        </div>
        @foreach ($packagings as $packaging)
            <div class="container row justify-content-center align-self-center">
                <div class="card p-1" style="width: 50mm; height: 25mm;">
                    <div class="p-2">
                        <p class="fontSize">
                            O.N.:{{ optional($packaging->orderList)->order->order_no }}|
                            C.N.:{{ optional($packaging->orderList)->order->customer->name }}|
                            P.:{{ optional($packaging->orderList)->order->customer->phone }}|
                        </p>
                        <p class="fontSize">
                            D:{{ $packaging->updated_at }}|
                            G:{{ $packaging->group_by }}
                        </p>
                        <p class="fontSize">
                            T:{{ optional($packaging->orderList)->product->name }}|
                            U:{{ optional($packaging->orderList)->unit->unit }}|
                            Q:{{ optional($packaging->orderList)->quantity }}|
                        </p>
                        <div class="row">
                            <div class="col-6">
                                <p><svg id="barcode"></svg></p>
                            </div>
                            <div class="col-6">
                                <p class="float-left"><svg id="dccode"></svg></p>
                            </div>
                        </div>
                        <p class="d-none" id="getValueBarcode">{{ $packaging->pricing_barcode }}</p>
                        <p class="d-none" id="getValueDC">{{ $packaging->delivery_code }}</p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    </div>
    <script>
        var barCode = $("#getValueBarcode").html();
        JsBarcode("#barcode", barCode);
        var getValueDC = $("#getValueDC").html();
        JsBarcode("#dccode", getValueDC);
    </script>


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
