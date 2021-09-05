@extends('layouts.theme')

@section('page_title', 'Price List')

@section('page_index')
<a href="{{ route('user.dashboard') }}">Dashboard </a> &nbsp;/ Price
@endsection

@section('main_content')

<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createModel"
    style="margin-left:90%">
    Add <i class="fa fa-plus"></i>
</button>
{{-- Create Modal part Start --}}
<div class="modal_part_create">
    <div class="modal fade" id="createModel" tabindex="-1" role="dialog" aria-labelledby="createModelLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModelLabel">Add New Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('price.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_id">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" list="product_id" required class="form-control">
                                <!-- <datalist id="product_id"> -->
                                @foreach ($products as $product)
                                    <option value="{{ $product->sku }}" calss="{{ $product->id }}">
                                        {{ $product->name }}</option>
                                @endforeach
                                <!-- </datalist> -->
                            </select>
                            @error('product_id')
                                <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="product_variant">Product Variant <span class="text-danger">*</span></label>
                            <select name="product_variant" id="product_variant" required class="form-control">
                                <option value="">Select Variant</option>
                                @foreach ($products as $product)
                                    @foreach ($product->sizes as $size)
                                        <option value="{{ $size }}">{{ $size }}</option>
                                    @endforeach

                                @endforeach
                            </select>
                            @error('product_variant')
                                <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Purchase Price <span class="text-danger">*</span></label>
                            <input type="number" id="purchase_create_price" name="purchase_price" required
                                class="form-control">
                            @error('product_price')
                                <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_price">New Price <span class="text-danger">*</span></label>
                            <input type="number" id="new_create_price" name="new_price" required class="form-control">
                            @error('product_price')
                                <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="normal_price">Normal Price <span class="text-danger">*</span></label>
                            <input type="number" id="normal_create_price" name="normal_price" required
                                class="form-control">
                            @error('product_price')
                                <div class="text-danger font-italic">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="loyal_price">Loyal Price <span class="text-danger">*</span></label>
                            <input type="number" id="loyal_create_price" name="loyal_price" required
                                class="form-control">
                            @error('product_price')
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
</div>
{{-- Create Modal part End --}}




<table id="example" class="table table-bordered border table-striped table-hover">
    <thead class="bg-info">
        <tr>
            <th>#Sl</th>
            <th>Product SKU</th>
            <th>Product Name</th>
            <th>Product Variant</th>
            <th>Purchase Price</th>
            <th>New Price</th>
            <th>Normal Price</th>
            <th>Loyal Price</th>
            <th>Per Unit</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sl = 1;
        @endphp
        @foreach ($prices as $price)
            <tr>
                <td class="{{ $price->id }}">
                    {{ $sl++ }}
                </td>

                <td>{{ optional($price->product)->sku }}</td>
                <td>{{ optional($price->product)->name }}</td>
                <td>{{ $price->product_variant }}</td>
                <td>{{ $price->purchase_price }} Tk</span>
                </td>
                <td>{{ $price->new_price }} Tk</td>
                <td>{{ $price->normal_price }} Tk</td>
                <td>{{ $price->loyal_price }} Tk</td>
                <td>Per/{{ optional($price->product)->unit->unit }}</td>
                <td>
                    <form action="{{ route('price.destroy', $price->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- <a href="{{ route('price.edit', $price->id) }}" class="btn btn-success btn-sm" class="text-muted">
                                            <i class="fas fa-edit"></i>
                                        </a>&nbsp; -->
                        <button type="button" class="btn btn-success btn-sm edit" data-toggle="modal"
                            data-target="#editModal">
                            <i class="fas fa-edit"></i>

                        </button>&nbsp;
                        <button type="submit" onclick="return confirm('Are you sure?')"
                            class="btn btn-danger btn-sm mt-1"><i class="fa fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>

<!--Edit Modal Part-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Price</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>



            <form action="#" method="POST" id="editForm">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="product_id">Product <span class="text-danger">*</span></label>
                        <input type="text" name="product_id" id="product_name" value="" required class="form-control"
                            disabled />

                        @error('product_id')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <!-- <label for="product_variant">Product Variant <span class="text-danger">*</span></label>
                                            <input type="text" name="product_variant" id="product_variant" required class="form-control" style="text-transform:uppercase;" oninput="this.value = this.value.toUpperCase()" value="" /> -->
                        <label for="product_variant">Product Variant <span class="text-danger">*</span></label>
                        <select name="product_variant" required class="form-control" id="product_var">
                            <option value="">Select Variant</option>
                        </select>
                        @error('product_variant')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="purchase_price">Purchase Price <span class="text-danger">*</span></label>
                        <input type="number" value="" name="purchase_price" required class="form-control"
                            id="purchase_price" />
                        @error('product_price')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_price">New Price <span class="text-danger">*</span></label>
                        <input type="number" id="new_price" name="new_price" required class="form-control">
                        @error('product_price')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="normal_price">Normal Price <span class="text-danger">*</span></label>
                        <input type="number" id="normal_price" name="normal_price" required class="form-control">
                        @error('product_price')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="loyal_price">Loyal Price <span class="text-danger">*</span></label>
                        <input type="number" id="loyal_price" name="loyal_price" required class="form-control">
                        @error('product_price')
                            <div class="text-danger font-italic">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <!-- /.card-body -->


            </form>



        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {

            //------------Edit  MODAL ------------------------------
            var table = $('#example').DataTable();

            table.on('click', '.edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = tr.prev('parent');
                }

                var data = table.row($tr).data();

                let id = $tr.children()[0].classList[0];
                $.ajax({
                    url: `/price/${id}/edit`,
                    type: 'get',
                    data: {
                        id: id
                    },

                    success: function(res) {

                        let data = res.data;

                        $('#product_name').val(data.product.name);
                        $('#product_var').html("");

                        for (i = 0; i < data.product.sizes.length; i++) {

                            $('#product_var').append(
                                `<option value="${data.product.sizes[i]}">${data.product.sizes[i]}</option>`
                            );

                        }

                    }
                });
                console.log($('#purchase_price'));

                $('#purchase_price').val(parseInt(data[4]));
                $('#new_price').val(parseInt(data[5]));
                $('#normal_price').val(parseInt(data[6]));
                $('#loyal_price').val(parseInt(data[7]));


                $('#editForm').attr('action', '/price/' + id);

            });

            //---------------------CREATE MODAL-----------------------

            $('#product_id').change(function() {
                let id = $('#product_id option:selected')[0].attributes[1].value;

                $.ajax({
                    url: `/price/${id}`,
                    type: 'get',
                    data: {
                        id: id
                    },

                    success: function(res) {

                        let data = res.data;
                        console.log(data);

                        $('#product_variant').html("");

                        for (i = 0; i < data.sizes.length; i++) {

                            $('#product_variant').append(
                                `<option value="${data.sizes[i]}">${data.sizes[i]}</option>`
                            );

                        }

                        $('#product_create_price').val(data.price);

                    }
                });


            });

        });
    </script>
@endpush

@endsection
