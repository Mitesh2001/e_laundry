@extends('layouts.app')

@section('content')
 <div class="container-fluid mt-5">
    <div class="col-sm-6 p-md-0  mt-2 mt-sm-0 d-flex">
        <a href="{{ route('service.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Service</h4>
                </div>
                <div class="card-body">
                    <x-form route="service.update" updateId="{{ $service->id }}" type="Submit" method="true">
                        <div class="form-group text-center">
                            <img width="50%" src="{{ $service->thumbnailPath }}" alt="">
                        </div>

                        <x-input name="name" placeholder="Service name" value="{{ $service->name }}" />
                        {{-- <x-input name="name_bn" placeholder="Service name bangla" value="{{ $service->name_bn }}" /> --}}

                        <label for="">
                            @foreach ($service->variants as $variant)
                            <span>{{ $variant->name }} </span>,
                            @endforeach
                        </label>
                        <x-select :multi="true" name="variant_ids[]">
                            @foreach ($variants as $variant)
                                <option value="{{ $variant->id }}" >{{ $variant->name }}</option>
                            @endforeach
                        </x-select>

                        <x-input-file name="image" />

                        <x-textarea name="description" placeholder="write description" value="{{ $service->description }}" />
                        {{-- <x-textarea name="description_bn" placeholder="write description bangla" value="{{ $service->description_bn }}" /> --}}
                    </x-form>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection

@push('scripts')
    <script>
        $('#name').keyup(function() {
            $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g,"-"));
		});
    </script>
@endpush
