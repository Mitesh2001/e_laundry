@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">Customer Details</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ url()->previous() }}"> Back </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $customer->user->first_name ? $customer->user->name : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Profile Photo</th>
                                <td>
                                    <img width="100" src="{{ $customer->user->profilePhotoPath }}" alt="{{ $customer->user->name }}">
                                </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        {{ $customer->user->email }}
                                        @if ($customer->user->email_verified_at)
                                            <span class="bg-success btn py-0 px-1">{{ $customer->user->email_verified_at->format('M d, Y') }}</span>
                                            @else
                                            <span class="bg-warning btn py-0 px-1">Unverified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>
                                        {{ $customer->user->mobile }}
                                        @if ($customer->user->mobile_verified_at)
                                            <span class="bg-success btn py-0 px-1">Verified</span>
                                            @else
                                            <span class="bg-warning btn py-0 px-1">Unverified</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ Carbon\Carbon::parse($customer->user->dob)->format('M d, Y') }}</td>
                                </tr>

                                @if (!$customer->addresses->isEmpty())
                                <tr>
                                    <th>Address</th>
                                    <td>
                                        @foreach ($customer->addresses as $key => $address)
                                        <div>
                                            {!! $key == 0 ? ' <hr class="my-2">' : '' !!}

                                            <span>{{ $address->address_name }}</span>,
                                            <span class="ml-2">{{ $address->address_line }}</span>

                                            <a href="#address_show_{{ $address->id }}" data-toggle="modal" class="btn btn-info p-1 px-2 ml-2">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <hr class="my-2">
                                            <!-- Modal -->
                                            <div class="modal fade" id="address_show_{{ $address->id }}">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $address->address_name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="col">Title</th>
                                                                    <th scope="col">Details</th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Name</td>
                                                                    <td>{{ $address->address_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Road</td>
                                                                    <td>{{ $address->road_no }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>House</td>
                                                                    <td>{{ $address->house_no }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Flat</td>
                                                                    <td>{{ $address->flat_no }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Address</td>
                                                                    <td>{{ $address->address_line }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif

                                @if (!$customer->orders->isEmpty())
                                <tr>
                                    <th>Orders</th>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                                            Show all Orders
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">All Order</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach ($customer->orders as $key => $order)
                                                    <div class="position-relative">
                                                        {!! $key == 0 ? ' <hr class="my-2">' : '' !!}
                                                        <span>Deliivery date: {{ Carbon\Carbon::parse($order->delivery_at)->format('M d, Y') }}</span>,
                                                        <span>Products: {{ $order->products->count() }}</span>
                                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-info p-1 px-2 ml-2 position-absolute" style="right:0; bottom:5px">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <hr class="my-2">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
