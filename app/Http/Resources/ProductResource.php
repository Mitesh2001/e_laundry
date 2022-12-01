<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $discount = null;
        if($this->old_price){
            $percentage = ceil(($this->price - $this->old_price) / $this->old_price * 100);
            $incrementOrDecrement = substr($percentage, 0 ,1);
            if($incrementOrDecrement == '-'){
                $discount = $percentage;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_bn' => $this->name_bn,
            'slug' => $this->slug,
            'current_price' => $this->price,
            'old_price' => $this->old_price,
            'image_path' => $this->thumbnailPath,
            'discount_percentage' => $discount,
            'service' => (new ServiceResource($this->service)),
            'variant' => (new VariantResource($this->variant))
        ];
    }
}
