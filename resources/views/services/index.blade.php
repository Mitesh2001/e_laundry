@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">All Service</h2>
                    <div class="w-100 text-right">
                        <a href="{{ route('additional.index') }}" class="text-right btn btn-info">Additional Services</a>
                        <a href="{{ route('service.create') }}" class="text-right btn btn-primary">Add New Service</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    {{-- <th scope="col">নাম</th> --}}
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col">Description</th>
                                    {{-- <th scope="col">বর্ণনা</th> --}}
                                    <th scope="col">Status</th>
                                    <th style="min-width: 130px" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    {{-- <td>{{ $service->name_bn ?? 'N\A' }}</td> --}}
                                    <td>
                                        <img width="100" src="{{ asset($service->thumbnailPath) }}" alt="">
                                    </td>
                                    <td>
                                        {{ substr($service->description, 0 ,25) }}
                                    </td>
                                    {{-- <td>
                                        {{ $service->description_bn ? substr($service->description_bn, 0 ,25) : 'N\A' }}
                                    </td> --}}
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('service.status.toggle', $service->id) }}">
                                                <input {{ $service->is_active ? 'checked':'' }} type="checkbox">
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    <td>
                                        <span>
                                            <a href="{{ route('service.edit', $service->id) }}" class="btn btn-sm btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </span>
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
