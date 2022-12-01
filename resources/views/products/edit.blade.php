@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0 mt-2 mt-sm-0 d-flex">
            <a href="{{ route('product.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-7 col-xxl-7 col-lg-7 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title m-0">Edit Product</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img width="50%" src="{{ $product->thumbnailPath }}" alt="">
                    </div>
                    <x-form type="Update" method="true" route="product.update" updateId="{{ $product->id }}">
                        <x-input name="name" placeholder="Category name" value="{{ old('name') ?? $product->name }}" />

                        {{-- <x-input name="name_bn" placeholder="Product name bangla" value="{{ old('name_bn') ?? $product->name_bn }}" /> --}}

                        <x-input name="price" placeholder="price" value="{{ old('price') ?? $product->price }}" />

                        <input type="hidden" id="slug" name="slug" class="form-control input-default" value="{{ old('slug') ?? $product->slug }}">

                        <x-select name="service_id">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" {{ $product->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </x-select>

                        <x-select name="variant_id">
                            @foreach ($variants as $variant)
                                <option {{ $product->variant_id == $variant->id ? 'selected' : '' }} value="{{ $variant->id }}">{{ $variant->name }}</option>
                            @endforeach
                        </x-select>

                        <x-input-file name="image" />

                        <div class="form-group">
                            <label for="active" class="mr-2">
                                <input type="radio" id="active" name="active" {{ $product->is_active ? 'checked' : '' }} value="1"> Active
                            </label>

                            <label for="in_active">
                                <input type="radio" id="in_active" name="active" {{ !$product->is_active ? 'checked' : '' }} value="0"> Inactive
                            </label>
                        </div>
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
