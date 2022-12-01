@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-2">
                            <h2 class="card-title">{{ config('enums.order_status.'.request('order-status')) }} Orders</h2>
                        </div>

                        <div class="col-10 position-relative" >
                            <form class="position-absolute" style="right: 1em" action="{{ route('order.index') }}" method="GET" >

                                    <input placeholder="Search" value="{{ \request('search') }}" name="search" type="text" class="form-control float-left" style="width: 200px">

                                <select class="form-control mx-2 float-left" name="status" style="width: 200px">
                                    <option value="">
                                        {{ in_array(config('enums.order_status.'.\request('status')), config('enums.order_status') ) ? config('enums.order_status.'.request('status')) : 'All' }}
                                    </option>

                                    @foreach (config('enums.order_status') as $key => $order_status)
                                        <option value="{{ $key }}" {{ $key == \request('status') ? 'selected' : '' }}>{{ $order_status }}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-https://meet.google.com/axs-wudq-whzmary"> <i class="fa fa-search"></i> </button>
                        </form>
                        </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Order Id</th>
                                    <th scope="col">Order By</th>
                                    <th scope="col">Order At</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->prefix . $order->order_code }}</td>
                                    <td>{{ $order->customer->user ? $order->customer->user->name : 'N/A' }}</td>
                                    <td>
                                        {{ $order->created_at->format('M d, Y') }} <br>
                                        <small>{{ $order->created_at->format('h:i a') }}</small>
                                    </td>
                                    <td>${{ $order->amount }}</td>
                                    <td>{{ $order->order_status }}</td>
                                    <td>
                                        <a href="#address{{ $order->id }}" data-toggle="modal" class="btn btn-primary">
                                            <i class="fa fa-address-card"></i>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="address{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Order Address</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Order ID: <strong>{{ $order->prefix . $order->order_code }}</strong></p>
                                                    <p>
                                                        Order From: <strong>{{ $order->address->address_name }}</strong>
                                                    </p>
                                                    <p>
                                                        Area: <strong>{{ $order->address->area }}</strong>
                                                    </p>
                                                    <p>
                                                        House Number: <strong>{{ $order->address->house_no }}</strong>
                                                    </p>
                                                    <p>
                                                        Flat Number: <strong>{{ $order->address->flat_no }}</strong>
                                                    </p>
                                                    <p>
                                                        Block: <strong>{{ $order->address->block }}</strong>
                                                    </p>
                                                    <p>
                                                        Road Number: <strong>{{ $order->address->road_no }}</strong>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
