@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">All products under {{ $variant->name }} variant</h2>
                        </div>

                        <div class="col-6 position-relative" >
                            <button  data-toggle="modal" data-target="#addNew" class="position-absolute btn btn-primary" style="right: 1em" >
                                Add New Variant
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    {{-- <th scope="col">নাম</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    {{-- <td>{{ $product->name_bn ?? 'N\A' }}</td> --}}
                                    <td>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update{{ $product->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="update{{ $product->id }}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h2 class="modal-title" id="exampleModalLabel">Edit Position</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form action="{{ route('product.update.order', $product->id) }}" method="POST">
                                                    @csrf  @method('put')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="text" name="position" class="form-control" value="{{ old('position') ?? $product->order }}" placeholder="Position">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
