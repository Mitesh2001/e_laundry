@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <!-- Revenue Charts -->
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">{{__('Income')}}</h6>
                                <h2 class="text-default mb-0">{{__('Revenue')}}</h2>
                            </div>

                            <div class="col-8">
                            <form action="{{ route('revenue.index') }}" method="GET">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item ml-2 mr-md-0">
                                        <x-input type="date" name='from' placeholder="Search Date" value="{{ request('from') }}" />
                                    </li>
                                    <li class="nav-item ml-2 mr-md-0">
                                        <x-input type="date" name='to' placeholder="Search Date" value="{{ request('to') }}" />
                                    </li>
                                    <li class="nav-item ml-2 mr-md-0">
                                       <button type="submit" class="btn btn-info">Filter</button>
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
                                        <tr>
                                            <td colspan="5">Sorry! Revenue report not found</td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="3" class="text-right">Total Revenue</td>
                                        <td>${{ $revenues->sum('amount') }}</td>
                                        <td>
                                            <a class="btn btn-warning"
                                            href="{{ route('revenue.generate.pdf', ['from' => \request('from'), 'to' => \request('to')]) }}">Print Report</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
