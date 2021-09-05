<div class="card">
    <div class="card-header border-transparent bg-info">
        <h4 class="text-center">Total Order</h4>
    </div>
    <!-- /.card-header -->
    <div class="card-body py-3">
        <div class="table-responsive">
            <table class="table m-0 mt-5" id="example">
                <thead>
                    <tr class="bg-secondary">
                        <th>#SL</th>
                        <th>Order ID</th>
                        <th>Total Product</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php($sl = 1)
                    @foreach ($orders as $order)
                        <tr>
                            <td class="{{ $order->id }}">{{ $sl++ }}</td>
                            <td><a href="{{ route('order.show', $order->id) }}">{{ $order->order_no }}</a></td>

                            <td>{{ optional($order->orderList)->count() }}</td>

                            <td>
                                <span
                                    class="{{ $order->status == 'pending' ? 'text-danger' : 'text-success' }}">{{ $order->status }}</span>
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
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <a href="{{ route('order.create') }}" class="btn btn-sm btn-info float-left">Place New Order</a>
        {{-- <a href="" class="btn btn-sm btn-secondary float-right">View All Orders</a> --}}
    </div>
    <!-- /.card-footer -->
</div>
