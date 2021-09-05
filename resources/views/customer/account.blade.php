@extends('layouts.theme')

@section('page_title', 'Customer Account Log')


@section('page_index')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a>Customer-Account-Log</a></li>
    </ol>
</nav>
@endsection

@section('main_content')

<table id="accountTable" class="table table-bordered table-striped table-hover">
    <thead class="bg-info">

        <tr>
            <th>#SL</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Total Sales</th>
            <th>Sales Amount</th>
            <th>Due</th>
        </tr>
    </thead>
    <tbody>
        @php($sl = 1)
        @foreach ($accounts as $account)

            <tr>
                <td class="{{ $account->id }}">{{ $sl++ }}</td>
                <td>{{ $account->customer->unique_id }}</td>
                <td>{{ $account->customer->name }}</td>
                <td>{{ $account->pendding_payment }}</td>
                <td>{{ $account->previous_due }}</td>
                <td>{{ $account->payment }}</td>
                <td>{{ $account->total_due }}</td>

                <td>
                    <button type="button" class="btn btn-success btn-sm editbtn" data-toggle="modal"
                        data-target="#editModal">Pay Now</button>
                </td>
            </tr>
        @endif




        @endforeach

    </tbody>
</table>
</div>

<!--Edit  Modal -->


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pay Now</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="customer_id">Customer Name <span class="text-danger">*</span></label>

                        <input type="text"
                            class="form-control @error('customer_id')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          is-invalid
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @enderror"
                            name="customer_id" id="customerID" value="" disabled />
                        @error('customer_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="payment">Payment<span class="text-danger">*</span></label>
                        <input type="number" name="payment" id="payment" value="" required class="form-control" />
                        @error('payment')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="accountEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#accountTable').DataTable();

            table.on('click', '.editbtn', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = tr.prev('parent');
                }
                var data = table.row($tr).data();
                let id = $tr.children()[0].classList[0];
                console.log(id);
                // $('#customerID').val(data[1]);
                $('#payment').val(data[6]);

                <<
                << << < HEAD
                    ===
                    === =
                    $('#customerID').val(data[1]);
                $('#payment').val(data[6]); >>>
                >>> > origin / zidny_invoice
                $('#editForm').attr('action', '/account/' + id);



            });

        });
    </script>
@endpush

@endsection
