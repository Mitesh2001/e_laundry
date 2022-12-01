@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h2 class="card-title float-left">All Customers</h2>
                        </div>

                        <div class="col-8">
                        <form action="{{ route('customer.index') }}" method="GET">
                            <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item ml-2 mr-md-0">
                                    <x-input type="text" name='search' placeholder="Search" value="{{ request('search') }}" />
                                </li>
                                <li class="nav-item ml-2 mr-md-0">
                                   <button type="submit" class="btn btn-info">
                                       <i class="fa fa-search"></i>
                                   </button>
                                </li>
                                <li class="nav-item ml-2 mr-md-0">
                                    <a href="{{ route('customer.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> New customer
                                    </a>
                                 </li>
                            </ul>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->user->name }}</td>
                                    <td>
                                        {{ $customer->user->email }}
                                    </td>
                                    <td>
                                        {{ $customer->user->mobile }}
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-primary py-1 px-2">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-info py-1 px-2">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    td{
        padding: 5px  10px !important;
    }
</style>
@endsection
