@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h2 class="card-title float-left">All Products</h2>
                        </div>

                        <div class="col-8">
                            <form action="{{ route('product.index') }}" method="GET">
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
                                        <a href="{{ route('product.create') }}" class="btn btn-primary">Add New Product</a>
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
                                    {{-- <th scope="col">নাম</th> --}}
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col">Variant</th>
                                    <th scope="col">Discount price</th>
                                    <th scope="col">Proce</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    {{-- <td>{{ $product->name_bn ? $product->name_bn : 'N\A' }}</td> --}}
                                    <td>
                                        <img width="100" src="{{ $product->thumbnailPath }}" alt="">
                                    </td>
                                    <td>{{ $product->variant->name }}</td>
                                    <td>${{ $product->price }}</td>
                                    <td>
                                        <del>${{  $product->old_price ? $product->old_price: '00'  }}</del>
                                    </td>
                                    <td>
                                        <label class="switch">
                                            <a href="{{ route('product.status.toggle', $product->id) }}">
                                                <input type="checkbox" {{ $product->is_active ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </a>
                                        </label>
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
