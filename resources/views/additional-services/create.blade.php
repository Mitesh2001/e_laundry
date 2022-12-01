@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="col-sm-6 p-md-0 mt-2 mt-sm-0 d-flex">
        <a href="{{ route('additional.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Additional Service</h4>
                </div>
                <div class="card-body">
                    <x-form route="additional.store" type="Submit">
                        <x-input name="title" placeholder="Title" />
                        {{-- <x-input name="title_bn" placeholder="Title Bangla name" /> --}}
                        <x-input name="price" placeholder="Price" type="number" />

                        <x-textarea name="description" placeholder="write description" />
                        {{-- <x-textarea name="description_bn" placeholder="write description bangla" /> --}}
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
