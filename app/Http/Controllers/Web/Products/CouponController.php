<?php

namespace App\Http\Controllers\Web\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Repositories\CouponRepository;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = (new CouponRepository())->getAll();

        return view('coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupon.create');
    }

    public function store(CouponRequest $request)
    {
        (new CouponRepository())->storeByRequest($request);

        return redirect()->route('coupon.index')->with('success', 'Coupon is added successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        (new CouponRepository())->updateByRequest($request, $coupon);

        return redirect()->route('coupon.index')->with('success', 'Coupon is updated successfully.');
    }
    
}
