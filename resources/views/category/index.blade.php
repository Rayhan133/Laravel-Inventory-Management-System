@extends('layouts.theme')

@section('page_title', 'Category List')

@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Catagory List</a></li>
        </ol>
    </nav>
@endsection

@section('main_content')



    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createZone"
        style="margin-left:90%">
        Add <i class="fa fa-plus"></i>
    </button>
    {{-- Create Modal part Start --}}
    <div class="modal_part_create">
        <div class="modal fade" id="createZone" tabindex="-1" role="dialog" aria-labelledby="createUnitLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModelLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="unit">Category <span class="text-danger">*</span></label>
                                <input type="text" name="name" list="category" required class="form-control" />
                                @error('name')
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



    <div class="">
        <table id="categoryEditTable" class="table table-bordered table-striped table-hover">
            <thead class="bg-info">
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Added By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sl = 1;
                @endphp
                @foreach ($categories as $categorie)

                    <tr>
                        <td class="{{ $categorie->id }}">{{ $sl++ }}</td>
                        <td>{{ $categorie->name }}</td>
                        <td>{{ $categorie->smgMenager->name }}</td>
                        <td>
                            <form action="{{ route('category.destroy', $categorie->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-success btn-sm editbtn" data-toggle="modal"
                                    data-target="#categoryEditModal">
                                    <i class="fas fa-edit"></i>
                                </button>&nbsp;
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Added By</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>

        <!--Edit  Modal -->
        <div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
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
                                    <label for="name">Category<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid
                                                                                                                                                                                @enderror"
                                        placeholder="category" name="name" id="category" value="" required />
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
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

        @push('js')
            <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
            <script>
                $(document).ready(function() {

                    var table = $('#categoryEditTable').DataTable();


                    table.on('click', '.editbtn', function() {

                        $tr = $(this).closest('tr');
                        if ($($tr).hasClass('child')) {
                            $tr = tr.prev('parent');
                        }

                        var data = table.row($tr).data();

                        let id = $tr.children()[0].classList[0];
                        console.log(id);

                        $('#category').val(data[1]);

                        $('#editForm').attr('action', '/category/' + id);

                    });

                });
            </script>
        @endpush

    @endsection
