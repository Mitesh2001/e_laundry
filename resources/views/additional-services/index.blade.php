@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">All Service</h2>
                    <div class="w-100 text-right">
                        <a href="{{ route('additional.create') }}" class="text-right btn btn-primary">Create Additional Service</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    {{-- <th scope="col">নাম</th> --}}
                                    <th scope="col">Description</th>
                                    {{-- <th scope="col">বর্ণনা</th> --}}
                                    <th scope="col">price</th>
                                    <th scope="col">Status</th>
                                    <th style="min-width: 130px" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($additionals as $additional)
                                <tr>
                                    <td>{{ $additional->title }}</td>
                                    {{-- <td>{{ $additional->title_bn ?? 'N\A' }}</td> --}}
                                    <td>
                                        {{ substr($additional->description, 0 ,25) }}
                                    </td>
                                    {{-- <td>
                                        {{ $additional->description_bn ? substr($service->description_bn, 0 ,25) : 'N\A' }}
                                    </td> --}}
                                    <td>&#2547;{{ $additional->price }}</td>
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('additional.status.toggle', $additional->id) }}">
                                                <input {{ $additional->is_active ? 'checked':'' }} type="checkbox">
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    <td>
                                        <span>
                                            <a href="{{ route('additional.edit', $additional->id) }}" class="btn btn-sm btn-primary">
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
