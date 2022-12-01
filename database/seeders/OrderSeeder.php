<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customrs = Customer::all();
        $coupons = Coupon::get();
        $faker = Factory::create();
        $coupon = $faker->randomElement($coupons);

        foreach($customrs as $key => $customr){
            Order::factory(rand(1, 10))->create([
                'customer_id' => $customr->id,
                'coupon_id' => $faker->randomElement($coupons)->id,
                'discount' => $coupon->discount,
            ]);
        }

        $orders = Order::all();
        $producs = Product::isActive()->get();

        foreach($orders as $order){
            foreach($faker->randomElements($producs, rand(2, 10)) as $product){
                $order->products()->attach($product->id);
            }
        }
    }
}
