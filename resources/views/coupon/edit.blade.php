@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <div class="row">
                        <div class="col-6">
                            <h2 class="card-title">Edit Coupon</h2>
                        </div>

                        <div class="col-6 position-relative" >
                            <div class="position-absolute" style="right: 1em" >
                                <a href="{{ route('coupon.index') }}" class="btn btn-dark"><i class="fa fa-arrow-left"></i>  Back</a>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="card-body">
                        <form action="{{ route('coupon.update', $coupon->id) }}" method="POST"> @csrf @method('put')
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <x-input name="code" value="{{ $coupon->code }}" placeholder="Coupon code"/>
                                </div>

                                <div class="col-12 col-md-6">
                                    <select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror">
                                        <option value="">Select discount type</option>
                                        @foreach (config('enums.coupons.discount_types') as $discountType)
                                        <option value="{{ $discountType }}" {{ $coupon->discount_type == $discountType ? 'selected' : ''}}>{{ $discountType }}</option>
                                        @endforeach
                                    </select>
                                    @error('discount_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <x-input name="discount" value="{{ $coupon->discount }}" placeholder="Discount"/>
                                </div>

                                <div class="col-12 col-md-6">
                                    <x-input name="min_amount" value="{{ $coupon->min_amount }}" placeholder="Minimum Amount"/>
                                </div>

                                <div class="col-12">
                                    <label for="">Started at</label>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <x-input type="date" value="{{ Carbon\Carbon::parse($coupon->started_at)->format('Y-m-d') }}" name="start_date"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <x-input type="time" value="{{ Carbon\Carbon::parse($coupon->started_at)->format('H:i') }}" name="start_time"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="">Expired at</label>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <x-input type="date" value="{{ Carbon\Carbon::parse($coupon->expired_at)->format('Y-m-d') }}" name="expired_date"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <x-input type="time" value="{{ Carbon\Carbon::parse($coupon->expired_at)->format('H:i') }}" name="expired_time"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-12 text-right">
                                    <button type="submit" class="btn btn-primary w-25">Submit</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
