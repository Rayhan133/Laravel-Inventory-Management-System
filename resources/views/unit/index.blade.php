@extends('layouts.theme')

@section('page_title', 'Set Unit')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Unit</li>
    </ol>
</nav>
@endsection

@section('main_content')

<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUnit"
    style="margin-left:90%">
    Add <i class="fa fa-plus"></i>
</button>
{{-- Create Modal part Start --}}
<div class="modal_part_create">
    <div class="modal fade" id="createUnit" tabindex="-1" role="dialog" aria-labelledby="createUnitLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModelLabel">Add New Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('unit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="unit">Unit <span class="text-danger">*</span></label>
                            <input type="text" name="unit" list="unit" required class="form-control" />
                            @error('unit')
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




<table id="setEditTable" class="table table-bordered table-striped table-hover">
    <thead class="bg-info">
        <tr>
            <th>#Sl</th>
            <th>Unit</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @php
        $sl = 1;
        @endphp
        @foreach ($units as $unit)
        <tr>
            <td class="{{ $unit->id }}">
                {{ $sl++ }}
            </td>
            <td>{{ $unit->unit }}</td>
            <td>
                <form action="{{ route('unit.destroy', $unit->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- <a href="{{ route('unit.edit', $unit->id) }}" data-target="#editUnit"
                                                        class="btn btn-success btn-sm" class="text-muted">
                                                        <i class="fas fa-edit"></i>
                                                    </a>&nbsp; -->
                    <!-- <button type="button" class="btn btn-success btn-sm mr-2 editbtn">
                                                        <i class="fas fa-edit"></i>
                                                    </button> -->
                    <button type="button" class="btn btn-success btn-sm editbtn" data-toggle="modal"
                        data-target="#setEditModal">
                        <i class="fas fa-edit"></i>

                    </button>&nbsp;
                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i
                            class="fa fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>#Sl</th>
            <th>Unit</th>
            <th>Actions</th>
        </tr>
    </tfoot>
</table>


<!--Edit  Modal -->
<div class="modal fade" id="setEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST" id="editForm">

                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Set Unit</label>
                            <input type="text" class="form-control @error('name')
                                                                        is-invalid
                                            @enderror" placeholder="Unit" name="unit" id="unit" value="" required />
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submmit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {

                var table = $('#setEditTable').DataTable();


                table.on('click', '.editbtn', function() {

                    $tr = $(this).closest('tr');
                    if ($($tr).hasClass('child')) {
                        $tr = tr.prev('parent');
                    }

                    var data = table.row($tr).data();

                    let id = $tr.children()[0].classList[0];
                    console.log(id);

                    $('#unit').val(data[1]);

                    $('#editForm').attr('action', '/unit/' + id);

                });

            });
</script>
@endpush




@endsection