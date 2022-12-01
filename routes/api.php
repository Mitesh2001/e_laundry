<?php

use App\Http\Controllers\API\Additional\AdditionalServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Order\OrderController;

use App\Http\Controllers\API\Banner\BannerController;
use App\Http\Controllers\API\Coupon\CouponController;
use App\Http\Controllers\API\Rating\RatingController;
use App\Http\Controllers\API\Address\AddressController;
use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\API\Service\ServiceController;
use App\Http\Controllers\API\Setting\SettingController;
use App\Http\Controllers\API\Variant\VariantController;
use App\Http\Controllers\API\Customers\CustomerController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Promotion\PromotionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/privacy-policy', function () {
    return view('settings.privacy-policy');
});

Route::middleware('guest:api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/forgot-password/otp/verify', [ForgotPasswordController::class, 'verifyOtp']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

Route::post('/resend/otp', [AuthController::class, 'resendOTP']);

Route::middleware(['auth:api', 'role:customer'])->group(function () {
    Route::post('/coupons/{coupon:code}/apply', [CouponController::class, 'apply']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);

    Route::post('/users/update', [UserController::class, 'update']);
    Route::post('/users/profile-photo/update', [UserController::class, 'updateProfilePhoto']);

    Route::get('/customers', [CustomerController::class, 'show']);

    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::post('/addresses/{address}', [AddressController::class, 'update']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/ratings', [RatingController::class, 'index']);
    Route::post('/ratings', [RatingController::class, 'store']);

    Route::post('/contact/verify', [AuthController::class, 'mobileVerify']);
});

Route::get('/banners', [BannerController::class, 'index']);
Route::get('/promotions', [PromotionController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/additional-services', [AdditionalServiceController::class, 'index']);
Route::get('/variants', [VariantController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/legal-pages/{page:slug}', [SettingController::class, 'show']);
