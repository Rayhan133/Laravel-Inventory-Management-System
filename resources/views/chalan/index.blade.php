@extends('layouts.theme')

@section('page_title')
    <p class="py-2"> Chalan </p>
@endsection

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Chalan</a></li>
        </ol>
    </nav>
@endsection

@section('main_content')
    <div class="row">
        <div class="col-8">
            <div class="form-group">
                <div class="row">
                    <div class="col-5">
                        <label for="ordernumber">Enter Order Number Or Barcode<span class="text-danger">*</span>
                            :</label>
                    </div>
                    <div class="col-6  d-flex">
                        <input type="number" id="orderNumberID" class="form-control" name="ordernumber"
                            placeholder="Enter Order Number Or Barcode" required value="{{ old('ordernumber') }}">
                        @error('ordernumber')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary form-control" id="find">Find</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <h4>Order Number: <span id="orderNumberShowID"></span></h4>
    <table id="example" class="table table-bordered table-striped table-hover">
        <thead class="bg-info">
            <tr>
                <th>#</th>
                <th>Order No</th>
                <th>Product Name</th>
                <th>Variant</th>
                <th>Quantity</th>
                <th>Product Unit</th>
                <th>Group By</th>
                <th>Status</th>
                <th>Delivery Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="chalanTableBody"> </tbody>
        <a href="" class=".btn btn-primary"></a>
    </table>





    @push('js')
        <script>
            $(document).ready(function() {
                $('#find').click(function() {
                    $('#chalanTableBody').html("");
                    $findId = $('#orderNumberID').val();
                    getOrderNumber($findId);


                })
            });

            function getOrderNumber($findId) {
                axios.get(`/chalan/find-order-number/${$findId}`)
                    .then((res) => {
                        $('#orderNumberShowID')[0].innerHTML = res.data.data[0].order_no;
                        let data = res.data.data;
                        for (let index = 0; index < data.length; index++) {
                            $("#chalanTableBody").append(`
                                <tr id="${data[index].id}">
                                    <td> ${index+1}</td>
                                    <td> ${data[index].order_no}</td>
                                    <td> ${data[index].product_name}</td>
                                    <td> ${data[index].variant}</td>
                                    <td> ${data[index].quantity}</td>
                                    <td> ${data[index].unit}</td>
                                    <td> ${data[index].group_by}</td>
                                    <td> ${data[index].delivery_status}</td>
                                    <td>
                                    <input  ${data[index].delivery_status =="Delivered"? "disabled" : ""} type="number" class="confirmDelivery" value="${data[index].delivery_status =="Delivered"? data[index].delivery_code : ""}">
                                    </td>
                                    <td>  <button class="confirm ${data[index].id} btn btn-success btn-sm"  >Confirm</button></td>
                                </tr>
                                `);
                        }


                        $(`.confirm`).click(function(e) {



                            $id = e.target.classList[1];

                            $confirm = $(e.target.closest('td').parentElement.children[8].children).val();

                            if (data[0].delivery_code == $confirm) {
                                console.log("confirmed");
                                axios.get(`/chalan/update-status/${$id}`)
                                    .then((res) => {
                                        $(e.target.closest('td').parentElement.children[8].children).prop(
                                            'disabled', true)
                                        $(e.target.closest('td').parentElement.children[7].innerHTML =
                                            "Delivered")
                                    })
                            } else {
                                $(e.target.closest('td').parentElement.children[7].innerHTML =
                                    "Wrong DC");
                                $(e.target.closest('td').parentElement.children[8].children).val("");
                                // alert("Wrong Delivery Code");
                            }


                        });




                    })


                $('#orderNumberID').val("");



            }



            // function myFunction(e){
            //     console.log(e)
            // }
        </script>

    @endpush

@endsection
