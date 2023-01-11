<?php

namespace App\Http\Controllers\API\Service;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Repositories\ServiceRepository;
use App\Models\Charge;

class ServiceController extends Controller
{
    public function index()
    {
        $services = (new ServiceRepository())->getActiveServices();

        $charges = Charge::select('vat','vat_type','delivery_charge')->first();

        $data =  [
            'services' => ServiceResource::collection($services),
            'vat' => $charges->vat,
            'vat_type' => $charges->vat_type,
            'delivery_charge' => $charges->delivery_charge
        ];

        return $this->json('service list',$data);
    }
}
