@extends('layouts.theme')

@section('page_title', 'Account')


@section('page_index')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a>Account</a></li>
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
                        <h5 class="modal-title" id="createModelLabel">Add New Zone</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('zone.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="zone">Zone Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" list="zone" required class="form-control" />
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


    <table id="zoneEditTable" class="table table-bordered table-striped table-hover">
        <thead class="bg-info">
            <tr>
                <th>#SL</th>
                <th>Zone Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php($sl = 1)
            @foreach ($zones as $zone)
                <tr>
                    <td class="{{ $zone->id }}">{{ $sl++ }}</td>
                    <td>{{ $zone->name }}</td>
                    <td>
                        <form action="{{ route('zone.destroy', $zone->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <!-- <a href="{{ route('zone.show', $zone->id) }}" class="btn btn-info btn-sm" class="text-muted">
                                                                                                <i class="fas fa-eye"></i>
                                                                                            </a>&nbsp; -->
                            <button type="button" class="btn btn-success btn-sm editbtn" data-toggle="modal"
                                data-target="#zoneEditModal">
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
                <th>#SL</th>
                <th>Zone Name</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
    </div>

    <!--Edit  Modal -->
    <div class="modal fade" id="zoneEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Zone</h5>
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
                                <label for="name">Zone Name</label>
                                <input type="text" class="form-control @error('name')
                                                                                                                                                                        is-invalid
                                                 @enderror" placeholder="Unit" name="name" id="zone" value="" required />
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
        <script>
            $(document).ready(function() {

                var table = $('#zoneEditTable').DataTable();


                table.on('click', '.editbtn', function() {

                    $tr = $(this).closest('tr');
                    if ($($tr).hasClass('child')) {
                        $tr = tr.prev('parent');
                    }

                    var data = table.row($tr).data();

                    let id = $tr.children()[0].classList[0];
                    console.log(id);

                    $('#zone').val(data[1]);

                    $('#editForm').attr('action', '/zone/' + id);

                });

            });
        </script>
    @endpush

@endsection
