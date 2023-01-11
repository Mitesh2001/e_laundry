<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Charge;

class ChargeController extends Controller
{
    public function index()
    {
        return view('settings.charges');
    }

    public function setCharges(Request $request)
    {
        $charge = new Charge();
        $charge->vat = $request->vat;
        $charge->vat_type = $request->vat_type;
        $charge->delivery_chargevat = $request->delivery_charge;
        $charge->save();
        return back();
    }

}
