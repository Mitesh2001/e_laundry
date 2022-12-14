<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    public function index()
    {
        $status = config('enums.order_status.' . request('status'));

        $orders = (new OrderRepository())->orderListByStatus($status);

        return $this->json('customer order list', [
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function store(OrderRequest $request)
    {
        $order = (new OrderRepository())->storeByRequest($request);

        if($request->has('additional_service_id')){
            $order->additionals()->sync($request->additional_service_id);
        }

        $notificationDetails =  [
            'title' => "Order Number : #IM".$order->id,
            'message' => "Your order status has been changes successfully !"
        ];

        $this->sendNotification($notificationDetails);

        $this->sendPushNotification($notificationDetails);

        return $this->json('order is added successfully', [
            'order' => new OrderResource($order)
        ]);
    }

    public function sendNotification($details)
    {
        (new OrderRepository())->sendNotificationByRequest(auth()->id(),$details);
    }

    public function sendPushNotification($details)
    {
        (new OrderRepository())->sendPushNotification(auth()->id(),$details);
    }

}
