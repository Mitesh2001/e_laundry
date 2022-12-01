
@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">App Banners</h2>
                    <div class="w-100 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                            Add New Banner
                        </button>
                    </div>
                    <div class="modal fade" id="createModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="exampleModalLabel">create a new banner</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data"> @csrf
                                <div class="modal-body">
                                    <x-input name='title' placeholder="Banner title" />

                                    <x-input-file name="image"/>

                                    <x-textarea name="description" placeholder="Banner description" />

                                    <div class="form-group">
                                        <label for="active">
                                            <input type="radio" id="active" name="active" value="1"> Active
                                        </label>
                                        <label for="in_active" class="ml-3">
                                            <input type="radio" id="in_active" name="active" value="1"> Inactive
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="banner">
                                            <input type="checkbox" id="banner" class="form-control-checkbox" name="banner" checked value="1"> Web Banner
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div> {{-- Modal End --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        {{ substr($banner->description, 0 ,30) }}
                                    </td>
                                    <td>
                                        <img width="100" src="{{ asset($banner->thumbnailPath) }}" alt="">
                                    </td>
                                    <td>

                                        <label class="switch">
                                            <a href="{{ route('banner.status.toggle', $banner->id) }}">
                                                <input type="checkbox" {{ $banner->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    <td>
                                        <span>
                                            <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-sm btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal_{{ $banner->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </span>

                                        <div class="modal fade" id="deleteModal_{{ $banner->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="exampleModalLabel">Delete a banner</h2>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                    <div class="modal-body">
                                                        <h3 class="text-warning">Are you sure?</h3>
                                                        <h5>You want to permanently delete this banner.</h5>
                                                        <img width="30%" src="{{ $banner->thumbnailPath }}" alt="">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <form action="{{ route('banner.destroy', $banner->id) }}" method="POST">
                                                            @csrf @method('delete')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  {{-- Modal End --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
