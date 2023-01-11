@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-lg-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Charges</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('charges.set') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="vatInput">VAT</label>
                            <input type="text" name="vat"  class="form-control" id="vatInput" placeholder="VAT Value">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="typeInput">VAT Type</label>
                            <select id="typeInput" name="vat_type" class="form-control">
                                <option selected>Choose...</option>
                                <option>Currency</option>
                                <option>Percentage</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="vatInput">Delivery Charge</label>
                            <input type="text" name="delivery_charge" class="form-control" id="vatInput" placeholder="Charge...">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Set</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
