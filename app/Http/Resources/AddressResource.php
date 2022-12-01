<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address_name' => $this->address_name,
            'road_no' => $this->road_no,
            'house_no' => $this->house_no,
            'flat_no' => $this->flat_no,
            'block' => $this->block,
            'area' => $this->area,
            'sub_district_id' => $this->sub_district_id,
            'district_id' => $this->district_id,
            'address_line' => $this->address_line,
            'post_code' => $this->post_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
