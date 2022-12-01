<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quantity = 0;
        foreach($this->products as $product){
            $quantity += $product->pivot->quantity;
        }

        return [
            'id' => $this->id,
            'order_code' => $this->order_code,
            'customer' => (new CustomerResource($this->customer)),
            'discount' => $this->discount,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'payment_type' => $this->payment_type,
            'pick_at' => Carbon::parse($this->pick_at)->format('d F, Y'),
            'delivery_at' => $this->delivery_at ? Carbon::parse($this->delivery_at)->format('d F, Y') : 'Next day',
            'ordered_at' => $this->created_at->format('Y-m-d h:i a'),
            'rating' => $this->rating ? $this->rating->rating : null,
            'quantity' => $quantity,
            'address' => (new AddressResource($this->address)),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
