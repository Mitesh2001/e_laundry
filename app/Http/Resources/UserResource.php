<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'mobile_verified_at' => $this->mobile_verified_at,
            'is_active' => $this->is_active,
            'alternative_phone' => $this->alternative_phone,
            'is_active' => $this->is_active,
            'profile_photo_path' => $this->profilePhotoPath,
        ];
    }
}
