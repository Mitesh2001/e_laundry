<?php

use App\Repositories\SMS;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Banners\BannerController;
use App\Http\Controllers\Web\Products\OrderController;
use App\Http\Controllers\Web\Products\CouponController;
use App\Http\Controllers\Web\Setting\SettingController;
use App\Http\Controllers\Web\Products\ProductController;
use App\Http\Controllers\Web\Revenues\RevenueController;
use App\Http\Controllers\Web\Services\ServiceController;
use App\Http\Controllers\Web\Variants\VariantController;
use App\Http\Controllers\Web\Customers\CustomerController;
use App\Http\Controllers\Web\Services\AdditionalServiceController;

/*
+--------------------------------------------------------------------------
+ Web Routes
+--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin|visitor|root'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('root');

    // Service routes
    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('service.store')->middleware('onlyAdmin');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('service.update')->middleware('onlyAdmin');
    Route::get('/services/{service}/toggle-status', [ServiceController::class, 'toggleActivationStatus'])
        ->name('service.status.toggle');
    Route::get('/services/{service}/variants', [ServiceController::class, 'getVariant'])->name('service.getVariant');

    // Additional service
    Route::get('/additional-services', [AdditionalServiceController::class, 'index'])->name('additional.index');
    Route::get('/additional-services/create', [AdditionalServiceController::class, 'create'])->name('additional.create');
    Route::post('/additional-services', [AdditionalServiceController::class, 'store'])->name('additional.store')->middleware('onlyAdmin');
    Route::get('/additional-services/{additional}/edit', [AdditionalServiceController::class, 'edit'])->name('additional.edit');
    Route::put('/additional-services/{additional}', [AdditionalServiceController::class, 'update'])->name('additional.update')->middleware('onlyAdmin');
    Route::get('/additional-services/{additional}/toggle-status', [AdditionalServiceController::class, 'toggleActivationStatus'])
        ->name('additional.status.toggle');

    // Variant routes
    Route::get('/variants', [VariantController::class, 'index'])->name('variant.index');
    Route::put('/variants/{variant}/', [VariantController::class, 'update'])->name('variant.update')->middleware('onlyAdmin');
    Route::post('/variants', [VariantController::class, 'store'])->name('variant.store')->middleware('onlyAdmin');
    Route::get('/variants/{variant}/products', [VariantController::class, 'productsVariant'])->name('variant.products');

    // Customer routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customers/{customer}/show', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customer.store')->middleware('onlyAdmin');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update')->middleware('onlyAdmin');

    // Product routes
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store')->middleware('onlyAdmin');
    Route::get('/products/{product}/show', [ProductController::class, 'show'])->name('product.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update')->middleware('onlyAdmin');
    Route::get('/products/{product}/toggle-status', [ProductController::class, 'toggleActivationStatus'])
    ->name('product.status.toggle');
    Route::put('/products/{product}/ordering', [ProductController::class, 'orderUpdate'])->name('product.update.order')->middleware('onlyAdmin');

    // Banner Routes
    Route::get('/web-banners', [BannerController::class, 'index'])->name('banner.index');
    Route::get('/mobile-banners', [BannerController::class, 'getPromotional'])->name('banner.promotional');
    Route::post('/banners', [BannerController::class, 'store'])->name('banner.store')->middleware('onlyAdmin');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banner.update')->middleware('onlyAdmin');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy')->middleware('onlyAdmin');
    Route::get('/banners/{banner}/toggle-status', [BannerController::class, 'toggleActivationStatus'])
        ->name('banner.status.toggle');

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/orders/{order}/update-status', [OrderController::class, 'statusUpdate'])->name('order.status.change')->middleware('onlyAdmin');
    Route::get('/orders/{order}/print/labels', [OrderController::class, 'printLabels'])
        ->name('order.print.labels');
    Route::get('/orders/{order}/print/invoice', [OrderController::class, 'printInvioce'])
        ->name('order.print.invioce');

    // Revenue Eoutes
    Route::get('revenues', [RevenueController::class, 'index'])->name('revenue.index');
    Route::get('revenues/generate-pdf', [RevenueController::class, 'generatePDF'])->name('revenue.generate.pdf');

    // Settings Routes
    Route::get('/settings/{slug}', [SettingController::class, 'show'])->name('setting.show');
    Route::get('/settings/{slug}/edit', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('/settings/{setting}', [SettingController::class, 'update'])->name('setting.update')->middleware('onlyAdmin');

    // Coupon Routes
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupon.store')->middleware('onlyAdmin');
    Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupon.update')->middleware('onlyAdmin');
});
