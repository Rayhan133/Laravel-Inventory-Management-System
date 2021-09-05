@php
$count = 0;
@endphp
@foreach ($Orders as $order)
    @if ($order->customer_id == $customer->id)
        <span class="d-none">
            {{ $count = $order->count() }}</span>
    @endif
@endforeach
@if ($count == 0)
    <h4>No Order Found</h4>
@else
    <div class="table-responsive">
        <table id="paymentTable2" class="table text-center m-auto" id="example1">
            <thead>
                <tr class="bg-secondary">
                    <th>#Sl</th>
                    <th>Order ID</th>
                    <th>Total Product</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                @endphp
                @foreach ($Orders as $order)
                    @php
                        $getDue = 0;
                    @endphp
                    @if ($order->created_at->toDateString() === date('Y-m-d'))
                        @if ($order->customer_id == $customer->id)
                            <tr>
                                <td class="{{ $order->id }}">
                                    {{ $sl++ }}
                                </td>
                                <td>
                                    <a href="{{ route('order.show', $order->id) }}">
                                        {{ $order->order_no }}
                                    </a>
                                </td>
                                <td>
                                    {{ $order->orderList->count() }}
                                </td>
                                <td>
                                    @php
                                        $orderwithlists = $order->orderList;
                                        $countPrice = 0;
                                        $ammountPrice = 0;
                                        $getPaymentValue = 0;
                                    @endphp
                                    @foreach ($orderwithlists as $orderwithlist)
                                    @php
                                        if($orderwithlist->price != null){
                                            if ($customer->account_type == 'new') {
                                                $price_type = $orderwithlist->price->new_price;
                                            } elseif ($customer->account_type == 'normal') {
                                                $price_type = $orderwithlist->price->normal_price;
                                            } else {
                                                $price_type = $orderwithlist->orderwithlist->loyal_price;
                                            }
                                            $countPrice = $countPrice + $price_type * $orderwithlist->quantity;
                                        }else{
                                            $countPrice = $countPrice + 0 * $orderwithlist->quantity;
                                        }
                                            
                                        @endphp
                                    @endforeach
                                    {{ number_format((float) $countPrice, 2, '.', '') }}
                                </td>
                                <td>
                                    @if ($customerAccountLogs->isEmpty())
                                        <small class="text-danger">No
                                            Payment</small>
                                    @else
                                        @foreach ($customerAccountLogs as $customerAccountLog)
                                            @if ($customerAccountLog->order_id === $order->id)
                                                @php
                                                    $getPaymentValue = $customerAccountLog->payment;
                                                @endphp
                                                <span style="cursor:pointer" class="text-primary showPaymentTotal"
                                                    data-toggle="modal" data-target=".bd-example-modal-lg-total">
                                                    {{ number_format((float) $getPaymentValue, 2, '.', '') }}
                                                </span>


                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                @php
                                        $orderwithlists = $order->orderList;
                                        $countPrice = 0;
                                        $ammountPrice = 0;
                                    @endphp
                                    @foreach ($orderwithlists as $orderwithlist)
                                        @php
                                            if ($customer->account_type == 'new') {
                                                $price_type = $orderwithlist->price->new_price;
                                            } elseif ($customer->account_type == 'normal') {
                                                $price_type = $orderwithlist->price->normal_price;
                                            } else {
                                                $price_type = $orderwithlist->price->loyal_price;
                                            }
                                            $countPrice = $countPrice + $price_type * $orderwithlist->quantity;
                                            $getDue = $countPrice - $getPaymentValue;
                                        @endphp
                                    @endforeach
                                    @if ($getDue == 0)
                                        <small class="text-success">No
                                            Due</small>
                                    @else
                                        {{ number_format((float) $getDue, 2, '.', '') }}
                                    @endif

                                </td>
                                <td class="text-center my-auto">
                                    <span
                                        class="{{ $order->status == 'pending' ? 'badge badge-danger' : 'badge badge-success' }}">
                                        {{ $order->status == 'pending' ? 'Pendding' : 'Deliverd' }}
                                    </span>
                                </td>

                                <td>
                                    @if ($getDue == 0)
                                        <span class="text-success">Paid
                                            ✔️</span>
                                    @else
                                        <button type="button" class="btn btn-success btn-sm editbtn2"
                                            data-toggle="modal" data-target="#totalEdit">
                                            Pay Now
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach


            </tbody>

        </table>
        {{-- Modal Edit Part start --}}
        <div class="modal fade" id="totalEdit" tabindex="-1" role="dialog" aria-labelledby="totalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="totalEditLabel">Payment Now
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="editForm2" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label for="payment">Payment<span class="text-danger">*</span></label>
                                <input type="number" name="payment" id="payment" value="" required
                                    class="form-control" />
                                @error('payment')
                                    <div class="text-danger font-italic">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="image">Payment
                                        Image
                                        upload</label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('image')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                is-invalid
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @enderror"
                                                name="image" id="image" accept="image/*">
                                            <label class="custom-file-label" for="image">Choose
                                                file</label>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="text-danger font-italic">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save
                                        changes</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Edit Part End --}}

        {{-- Show Payment History start --}}
        <div class="modal fade bd-example-modal-lg-total" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="card-title">
                                Payment History</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th>#Sl</th>
                                        <th>Amount</th>
                                        <th>Payment Date and Time</th>
                                        <th style="width: 80px">Payment Image</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentBodyTotal">
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
            </div>
        </div>
        {{-- Show Payment History End --}}

        <!-- /.table-responsive -->
    </div>
@endif
@push('js')

    <script>
        $(document).ready(function() {

            var table2 = $('#paymentTable2').DataTable();


            table2.on('click', '.editbtn2', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = tr.prev('parent');
                }
                var data = table2.row($tr).data();
                let id = $tr.children()[0].classList[0];
                console.log("Data", data);
                console.log("ID", id);
                $('#editForm2').attr('action', '/customer/' + id + '/payment/');
            });

            table2.on('click', '.showPaymentTotal', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = tr.prev('parent');
                }
                var data = table2.row($tr).data();
                let id = $tr.children()[0].classList[0];
                // console.log("ID", id);
                // console.log();
                console.log("Total", id);

                $.ajax({
                    url: `/customer/payment_history/${id}`,
                    type: 'get',
                    data: {
                        id: id
                    },
                    success: function(res) {
                        let data = res.data;
                        $('#paymentBodyTotal').html("");
                        for (let index = 0; index < data.length; index++) {

                            $("#paymentBodyTotal").append(`
                        <tr>
                            <td> ${index+1}</td>
                            <td> ${data[index].payment_history}</td>
                            <td> ${moment(data[index].updated_at)
                            .format("Do MMMM YYYY, h:mm:ss a")}</td>
                            <td>
                                <a href="/storage/Payment_image_/${data[index].image}" data-lightbox="example-set" data-title="Amount ${data[index].payment_history}৳ and Date:  ${moment(data[index].updated_at)
                            .format("Do MMMM YYYY, h:mm:ss a")}">
                                <img src="/storage/Payment_image_/${data[index].image}" alt="${data[index].image}" width="35" height="35"></a></td>
                        </tr>
                        `);
                        }
                    }
                });




            });






        });
    </script>
@endpush
