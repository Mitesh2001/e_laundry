<?php

namespace App\Http\Controllers\API\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function apply($couponCode, ApplyCouponRequest $request)
    {
        $coupon = (new CouponRepository())->findByCoupon($couponCode);
        if($coupon && $coupon->isValid($request->amount)->first()){
            return $this->json('Coupon applied successfully', [
                'coupon' => new CouponResource($coupon)
            ]);
        }

        return $this->json('Invalid coupon', [], Response::HTTP_BAD_REQUEST);
    }
}
