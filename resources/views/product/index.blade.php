@extends('layouts.theme')

@section('page_title', 'Products')

@section('page_index')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a>Products</a></li>
    </ol>
</nav>
@endsection

@section('main_content')
@role('super_admin|admin|smg_manager')
<a href="{{ route('product.create') }}">
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUnit"
        style="margin-left:90%">
        Add <i class="fa fa-plus"></i>
    </button>
</a>
@endrole

<table id="example" class="table table-bordered table-striped table-hover">
    <thead class="bg-info">

        <tr>
            <th>#Sl</th>
            <th>Product SKU</th>
            <th>Product Name</th>
            @role('super_admin|admin|smg_manager|sales_executive')
            <th>Actions</th>
            @endrole
        </tr>
    </thead>
    <tbody>
        @php
        $sl = 1;
        @endphp
        @foreach ($products as $product)
        <tr>
            <td>
                {{ $sl++ }}
            </td>
            <td>
                {{ $product->sku }}
            </td>
            <td>
                {{ $product->name }}
            </td>

            @role('super_admin|admin|smg_manager|sales_executive')
            <td>
                <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success btn-sm"
                        class="text-muted">
                        <i class="fas fa-edit"></i>
                    </a>&nbsp;
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                </form>
            </td>
            @endrole
        </tr>
        @endforeach
    </tbody>

</table>



@endsection