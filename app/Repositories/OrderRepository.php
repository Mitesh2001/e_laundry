<?php


namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Additional;
use App\Models\Coupon;
use App\Notifications\OrderNotification;

class OrderRepository extends Repository
{
    public function model()
    {
        return Order::class;
    }

    public function getByStatus($status)
    {
        return $this->model()::where('order_status', $status)->get();
    }

    public function storeByRequest(OrderRequest $request): Order
    {
        $lastOrder = $this->model()::latest('id')->first();

        $customer = auth()->user()->customer;
        $getAmount = $this->getAmount($request);

        $order = $this->model()::create([
            'customer_id' => $customer->id,
            'order_code' => str_pad($lastOrder ? $lastOrder->id + 1 : 10, 6, "0", STR_PAD_LEFT),
            'prefix' => 'IM',
            'coupon_id' => $request->coupon_id,
            'discount' => $getAmount['discount'],
            'pick_at' => $request->pick_at,
            'amount' => $getAmount['oldPrice'],
            'total_amount' => $getAmount['total'],
            'payment_status' => config('enums.payment_status.pending'),
            'payment_type' => config('enums.payment_types.cash_on_delivery'),
            'order_status' => config('enums.payment_status.pending'),
            'address_id' => $request->address_id,
            'instruction' => $request->instruction
        ]);

        foreach($request->products as $product){
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return $order;
    }

    private function getAmount(OrderRequest $request): array
    {
        $totalAmount = 0;
        $totalOldAmount = 0;
        foreach($request->products as $item){
            $product = (new ProductRepository())->findById($item['id']);
            $totalAmount += $product->price * $item['quantity'];
            $totalOldAmount += $product->old_price * $item['quantity'];
        }

        $totalServiceAmount = 0;
        if($request->has('additional_service_id')){
            $totalServiceAmount = Additional::whereIn('id', $request->additional_service_id)->get()->sum('price');
        }

        $oldPrice = $totalOldAmount + $totalServiceAmount;
        $couponDiscount = $this->getDiscount($request->coupon_id, $oldPrice);
        $discount = $totalOldAmount - $totalAmount + $couponDiscount;
        $totalAmount = ($totalAmount + $totalServiceAmount) - $couponDiscount;

        if($oldPrice <= 100){
            $oldPrice = $oldPrice + 29;
            $totalAmount = $totalAmount + 29;
        }

        return ['total' => $totalAmount, 'discount' => $discount, 'oldPrice' => $oldPrice];
    }

    private function getDiscount($couponId, $totalAmount)
    {
        $coupon = Coupon::where('id', $couponId)->isValid($totalAmount)->first();
        if($coupon && $coupon->isValid($totalAmount)->first()){
            $discount = $coupon->discount;
            if($coupon->discount_type == 'percent'){
                $discount = ($totalAmount / 100) * $coupon->discount;;
            }
            return $discount;
        }
        return 0;
    }

    public function getSortedByRequest(Request $request)
    {
        $status = $request->status;
        $searchKey = $request->search;

        $orders = $this->model()::query();

        if ($status) {
            $status = config('enums.order_status.' . $status);

            $orders = $orders->where('order_status', $status);
        }

        if ($searchKey) {
            $orders = $orders->where(function ($query) use ($searchKey) {
                $query->orWhere('order_code', 'like', "%{$searchKey}%")
                    ->orWhereHas('customer', function ($customer) use ($searchKey) {
                        $customer->whereHas('user', function ($user) use ($searchKey) {
                            $user->where('first_name', $searchKey)
                                ->orWhere('last_name', $searchKey)
                                ->orWhere('mobile', $searchKey);
                        });
                    })
                    ->orWhere('prefix', 'like', "%{$searchKey}%")
                    ->orWhere('amount', 'like', "%{$searchKey}%")
                    ->orWhere('payment_status', 'like', "%{$searchKey}%")
                    ->orWhere('order_status', 'like', "%{$searchKey}%");
            });
        }

        return $orders->latest()->paginate();
    }

    public function orderListByStatus($status = null)
    {
        $customer = auth()->user()->customer;
        $orders = $this->model()::where('customer_id', $customer->id);

        if($status){
            $orders = $orders->where('order_status', $status);
        }

        return $orders->latest()->get();
    }

    public function statusUpdateByRequest(Order $order, $status): Order
    {
        $order->update([
            'order_status' => $status,
            'delivery_at' => now(),
        ]);
        return $order;
    }

    public function getRevenueReportByBetweenDate($form, $to)
    {
        return  $this->model()::whereBetween('delivery_at', [$form, $to])
            ->where('order_status', config('enums.order_status.delivered'))
            ->get();
    }

    public function findById($id)
    {
        return $this->model()::find($id);
    }

    public function sendNotificationByRequest($userId,$details)
    {
        $user = User::find($userId);
        $user->notify(new OrderNotification($details));
    }

    public function sendPushNotification($userId,$details)
    {
        $user = User::find($userId);
        $fields = array(
            'registration_ids' => [$user->fcm_token],
            'data' => array('message' => json_encode($details))
        );

        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization:key=AAAA3Px39mI:APA91bFlzQJw8MHJybmzlAI4ZHzB-Cx9GGkaP4Tl0T-KKl6anW0dYCK3TI9Mu0xRzE81nVwZBybTEkmmNncL1TaBOI994J_i2Ti33NGHcsg9HecI1GZ0PkESO1p97hhWUNXszoUU1FIx',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
        //echo $result;

    }
}
