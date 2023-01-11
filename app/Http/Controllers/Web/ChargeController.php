<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charge;

class ChargeController extends Controller
{
    public function index()
    {
        $charges = Charge::first();
        return view('settings.charges',['charge' => $charges]);
    }

    public function setCharges(Request $request)
    {
        $charge = Charge::first();
        $charge->vat = $request->vat;
        $charge->vat_type = $request->vat_type;
        $charge->delivery_charge = $request->delivery_charge;
        $charge->save();
        return back();
    }
}
