@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">All Variants</h2>
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
                                @foreach ($variants as $variant)
                                <tr>
                                    <td>{{ $variant->name }}</td>
                                    {{-- <td>{{ $variant->name_bn ?? 'N\A' }}</td> --}}
                                    <td>

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update{{ $variant->id }}">
                                            <i class="far fa-edit"></i>
                                        </button>

                                        <a href="{{ route('variant.products', $variant->id) }}" class="btn btn-info">Products</a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="update{{ $variant->id }}">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h2 class="modal-title" id="exampleModalLabel">Edit Variant</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form action="{{ route('variant.update', $variant->id) }}" method="POST">
                                                    @csrf  @method('put')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="text" name="name" class="form-control" value="{{ old('name') ?? $variant->name }}">
                                                        </div>

                                                        {{-- <div class="mb-3">
                                                            <input type="text" name="name_bn" value="{{ old('name_bn') ?? $variant->name_bn }}" class="form-control" placeholder="Variant Name Bnagla">
                                                        </div> --}}

                                                        <div class="mb-3">
                                                            <input type="text" name="position" class="form-control" value="{{ old('position') ?? $variant->position }}" placeholder="Position">
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

<!-- Modal -->
<div class="modal fade" id="addNew">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Edit Variant</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('variant.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Variant Name">
                </div>

                {{-- <div class="mb-3">
                    <input type="text" name="name_bn" class="form-control" value="{{ old('name_bn') }}" placeholder="Variant Name Bnagla">
                </div> --}}

                <div class="mb-3">
                    <input type="text" name="position" class="form-control" value="{{ old('position')}}" placeholder="Position">
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
@endsection
