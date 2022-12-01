@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left">Order details of {{ $order->customer->user->name }}</h2>

                    <div class="text-right">
                        <a class="btn btn-light" href="{{ url()->previous() }}"> Back </a>
                        <a class="btn btn-danger" href="{{ route('order.print.invioce', $order->id) }}" target="_blank"><i class="fas fa-print"></i> Print </a>

                        <div class="drop-down">
                            <a class="btn btn-primary" style="min-width:150px" href="#status" data-toggle="collapse"  aria-expanded="false" role="button" aria-controls="navbar-examples">
                                <span class="nav-link-text">{{__($order->order_status)}}</span>
                                <i class="fa fa-chevron-down"></i>
                            </a>

                            <div class="collapse drop-down-items mt-1" id="status">
                                <ul class="nav nav-sm flex-column">
                                    @foreach (config('enums.order_status') as $key => $order_status)
                                    <li class="nav-item">
                                        <a class="nav-link"
                                            href="{{ route('order.status.change', ['order' => $order->id, 'status' => $key]) }}">
                                        {{__($order_status)}}
                                    </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $order->customer->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Customer photo</th>
                                <td>
                                    <img style="max-width: 200px" src="{{ $order->customer->profilePhotoPath }}" alt="">
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $order->customer->user->email }}
                                    @if ($order->customer->user->email_verified_at)
                                    <span class="badge bg-success text-dark">Verified</span>
                                    @else
                                    <span class="badge bg-danger text-white">Unverified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Phone number</th>
                                <td>
                                    @if ($order->customer->user->mobile)
                                        {{ $order->customer->user->mobile }}
                                        @if ($order->customer->user->mobile_verified_at)
                                        <span class="badge bg-success text-dark">Verified</span>
                                        @else
                                        <span class="badge bg-danger text-white">Unverified</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Order status</th>
                                <td>{{ $order->order_status }}</td>
                            </tr>
                            <tr>
                                <th>Payment status</th>
                                <td>{{ $order->payment_status }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>${{ $order->discount }}</td>
                            </tr>
                            <tr>
                                <th>Total amount</th>
                                <td>${{ $order->amount - $order->discount }}</td>
                            </tr>
                            <tr>
                                <th>Total Quantity</th>
                                <td>{{ $quantity }} pieces</td>
                            </tr>
                            <tr>
                                <th>Items</th>
                                <td>{{ $order->products->count() }}</td>
                            </tr>
                            <tr>
                                <th>Picked At</th>
                                <td>
                                    <span class="badge bg-light text-dark">{{ Carbon\Carbon::parse($order->pick_at)->format('M d, Y h:i a') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Delivery At</th>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $order->delivery_at ? Carbon\Carbon::parse($order->delivery_at)->format('M d, Y h:i a') : 'Next day' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Products</th>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                                        Show all order products
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">All order products</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach ($order->products as $product)
                                                <div class="bg-white my-2 py-2 overflow-hidden">
                                                    <img width="120" class="float-left mr-4" src="{{ $product->thumbnailPath }}" alt="">
                                                    <div class="overflow-hidden">
                                                        <h4>{{ $product->name }}</h4>
                                                        <p class="m-0">Price: {{ $product->price }}</p>
                                                        <p>Quantity: {{ $product->pivot->quantity }}</p>
                                                    </div>
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

                            <tr>
                                <th>Labels</th>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#labals">
                                       Order Labels
                                    </button>

                                    <a href="{{ route('order.print.labels', ['order' => $order->id, 'quantity' => $quantity]) }}" target="_blank" class="btn btn-danger">
                                        Print <i class="fas fa-print"></i>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="labals">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content" style="background: #f6f6f6;">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">All order labels</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    @php
                                                        $r = 1
                                                    @endphp
                                                    @foreach ($order->products as $key => $product)
                                                        @for ($i = 0; $i < $product->pivot->quantity; $i++)
                                                        <div class="col-4">
                                                            <div class="card text-dark bg-white shadow bg-body rounded my-2 p-2">
                                                                <h4 class="m-0">Name: {{ $order->customer->user->name }}</h4>
                                                                <h4 class="m-0">Order Id: #{{ $order->prefix . $order->order_code }}</h4>
                                                                <h4 class="m-0">Date: {{ Carbon\Carbon::parse($order->delivery_at)->format('M d, Y') }}</h4>
                                                                <h4 class="m-0">Title: {{ $product->name }}</h4>
                                                                <h4 class="m-0">Item: {{ $r .'/'. $quantity }}</h4>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $r++
                                                        @endphp
                                                        @endfor
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Additional Instruction:</th>
                                <td>{{ $order->instruction ?? 'N\A' }}</td>
                            </tr>

                            <tr>
                                <th>Additional Service</th>
                                <td>
                                    <button type="button" data-target="#additional" data-toggle="modal" class="btn btn-primary">
                                        Additional Services <span class="badge badge-dark m-0">{{ $order->additionals->count() }}</span>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="additional">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="background: #f6f6f6;">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">All order labels</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>price</th>
                                                    </tr>
                                                    @foreach ($order->additionals as $additional)
                                                    <tr>
                                                        <td>{{ $additional->title }}</td>
                                                        <td>{{ $additional->description }}</td>
                                                        <td>{{ $additional->price }}</td>
                                                    </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th> Rating</th>
                                <td>
                                    @php
                                        $rate = $order->rating ? $order->rating->rating : 0
                                    @endphp
                                    <i class="fas fa-star {{ $rate >= 1 ? 'rate' : 'unrate' }}"></i>
                                    <i class="fas fa-star {{ $rate >= 2 ? 'rate' : 'unrate' }}"></i>
                                    <i class="fas fa-star {{ $rate >= 3 ? 'rate' : 'unrate' }}"></i>
                                    <i class="fas fa-star {{ $rate >= 4 ? 'rate' : 'unrate' }}"></i>
                                    <i class="fas fa-star {{ $rate == 5 ? 'rate' : 'unrate' }}"></i>

                                    <br>
                                    {{ $order->rating ? $order->rating->content : null }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        .rate{
            color: rgb(255, 166, 0)
        }
        .unrate{
            color: rgb(136, 136, 136)
        }
    </style>
</div>
@endsection
