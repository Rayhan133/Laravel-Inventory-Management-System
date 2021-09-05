@extends('layouts.theme')

@section('page_title')
    Invoice Packaging
@endsection
@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Packaging</a></li>
        </ol>
    </nav>
@endsection
@section('main_content')

    <h4 class="bg-primary text-center py-2">Today's Packaging Chalan</h4>
    <table id="example" class="table table-bordered table-striped table-hover">
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Product Variant</th>
                <th>Quantity</th>
                <th>Group</th>
                <th>Unit</th>
                <th>Barcode</th>
                <th>DC</th>
            </tr>
        </thead>
        <tbody id="tableBody"> </tbody>
    </table>
    <div class="d-flex justify-content-between py-3">
        <div class="">
            <form action="{{ route('packaging.update') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-sm mt-2">Generate Barcode and DC</button>
            </form>
        </div>
        <div class="">
            <form action="{{ route('packaging.print') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-info btn-sm mt-2" target="_blank">Print All</button>
            </form>
        </div>
    </div>



    @push('js')

        <script>
            $(document).ready(function() {
                axios.get(`/packaging/fetch-all-data`)
                    .then((res) => {
                        if (res.data.status) {
                            alldata(res.data.data);
                        }
                    })

            });

            function alldata(data) {

                var newArray = [];
                data.forEach(element => {
                    newArray = [...newArray, {
                        newArrayOrder_no: element.order_list.order.order_no,
                        newArrayProductName: element.order_list.product.name,
                        newArrayVariant: element.order_list.variant,
                        newArrayQuantity: element.order_list.quantity,
                        newArrayGroup: element.group_by,
                        newArrayStatus: element.pricing_status,
                        newArrayUnit: element.order_list.unit.unit,
                        newArrayBarCode: element.pricing_barcode,
                        newArrayDelivery_code: element.delivery_code,
                    }];
                });




                $('#tableBody').html("");
                var count = 1;
                newArray.map(element => {

                    $("#tableBody").append(`<tr>
                        <td>${count++}</td>
                        <td>${element.newArrayOrder_no}</td>
                        <td>${element.newArrayProductName}</td>
                        <td>${element.newArrayVariant}</td>
                        <td>${element.newArrayQuantity}</td>
                        <td>${element.newArrayGroup}</td>
                        <td>${element.newArrayUnit}</td>
                        ${(element.newArrayStatus !== 0)?
                        `<td>${element.newArrayBarCode}</td>
                                   <td>${element.newArrayDelivery_code}</td>`
                        : `<td></td>
                                 <td></td>`
                        }


                    </tr>`);


                });

            }
        </script>


    @endpush

@endsection
