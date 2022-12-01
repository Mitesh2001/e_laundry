@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="header pt-5">

        <div class="header-body mt--4">
            <div class="row align-items-center pb-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 d-inline-block">{{__('Dashboard')}}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item "><a href="{{ route('root') }}"><i class="fa fa-home text-primary"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page"> {{__('Dashboard')}} </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Income')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">${{ $income }}</span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/earning.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Users')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">{{ $customers->count() }}</span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/user.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Products')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">{{ $products->count() }}</span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/items.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-3 text-right">
                                    <h4 class="card-title text-uppercase text-muted mb-0">{{__('Services')}}</h4>
                                    <span class="display-3 text-dark font-weight-bold mb-0">{{ $services->count() }} </span>
                                </div>
                                <div class="card-icon">
                                    <div class="icon icon-shape text-white shadow">
                                        <img width="80" src="{{ asset('images/icons/services.svg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 col-lg-8">

            <div class="card p-3">
                <div class="">
                    <h3 class="m-0 float-left">Revenue</h3>
                    <div class="text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary py-1 dropdown-toggle" type="button" id="filter-revunue" data-toggle="dropdown" aria-expanded="false">
                                Today
                            </button>
                            <div class="dropdown-menu" aria-labelledby="filter-revunue">
                              <a class="dropdown-item" href="#">Today</a>
                              <a class="dropdown-item" href="#">Yesterday</a>
                            </div>
                        </div>

                        <a class="btn py-1 text-white" href="{{ route('revenue.generate.pdf', ['filter' => request('filter'), 'filter_date' => request('filter_date')]) }}" target="_blank" style="background: #513AFF">
                            <i class="fas fa-file-download mr-1"></i> Download
                        </a>
                    </div>
                </div>
                <hr class="my-3">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">Delivery at</th>
                            <th scope="col">Order By</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Revenue</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($revenues as $revenue)
                            <tr>
                                <td>
                                    {{ Carbon\Carbon::parse($revenue->delivery_at)->format('M d, Y') }} <br>
                                    <small>{{ Carbon\Carbon::parse($revenue->delivery_at)->format('h:i a') }}</small>
                                </td>
                                <td>{{ $revenue->customer->user->name }}</td>
                                <td>{{ $revenue->quantity }} Pieces</td>
                                <td>${{ $revenue->amount }}</td>
                                <td>
                                    <a href="{{ route('order.show', $revenue->id) }}" class="btn btn-primary">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5">sorry, Today's revenue not found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="3" class="text-right">Total Revenue</td>
                            <td colspan="2">${{ $revenues->sum('amount') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="col-12 col-lg-4">
            <div class="card" style="border-radius: 10px; border-bottom: 4px solid #513aff;">
                <div class="overview">
                    <img width="100%" src="{{ asset('web/bg/overview.svg') }}" alt="">
                    <div>
                        <h2 class="text-white">Overview</h2>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/users.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $customers->count() }}</h3>
                            <span class="txt-1">Users</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/Orders.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $confirmOrder }}</h3>
                            <span class="txt-1">Orders</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/Pending.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $pendingOrder }}</h3>
                            <span class="txt-1">Pending</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 mb-3">
                        <img width="50" src="{{ asset('images/icons/progress.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{  $onPregressOrder }}</h3>
                            <span class="txt-1">On progress</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4">
                        <img width="50" src="{{ asset('images/icons/delivered.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $completeOrder }}</h3>
                            <span class="txt-1">Delivered</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-4 ">
                        <img width="50" src="{{ asset('images/icons/order.svg') }}" class="float-left mr-2" alt="">
                        <div>
                            <h3 class="m-0 text-dark">{{ $cancelledOrder }}</h3>
                            <span class="txt-1">Cancel order</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
