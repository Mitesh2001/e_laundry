@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">Coupons</h2>
                        </div>

                        <div class="col-6 position-relative" >
                            <div class="position-absolute" style="right: 1em" >
                                <a href="{{ route('coupon.create') }}" class="btn btn-primary">Create coupon</a>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Discount type</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">Min Amount</th>
                                    <th scope="col">Started at</th>
                                    <th scope="col">Expired at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code}}</td>
                                    <td>{{ $coupon->discount_type }}</td>
                                    <td>{!! $coupon->discount_type == 'amount' ? '$'.$coupon->discount : $coupon->discount.'%' !!}</td>
                                    <td>${{ $coupon->min_amount }}</td>
                                    <td>{{ Carbon\Carbon::parse($coupon->started_at)->format('M d, Y h:i a') }}</td>
                                    <td>{{ Carbon\Carbon::parse($coupon->expired_at)->format('M d, Y h:i a') }}</td>

                                    <td>
                                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
