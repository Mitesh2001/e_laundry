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
                        <h2 class="card-title m-0">Add Product</h2>
                    </div>
                    <div class="card-body">
                        <x-form route="product.store" type="Submit">
                            <x-input name="name" placeholder="Product name"/>

                            {{-- <x-input name="name_bn" placeholder="Product name bangla"/> --}}

                            <x-input name="price" type="number" placeholder="price"/>

                            <input type="hidden" id="slug" name="slug" class="form-control input-default" value="{{ old('slug') }}">

                            <x-select name="service_id">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </x-select>

                            <x-select name="variant_id" />

                            <x-input-file name="image" />

                            <div class="form-group">
                                <label for="active" class="mr-2">
                                    <input checked type="radio" id="active" name="active" value="1"> Active
                                </label>

                                <label for="inActive">
                                    <input type="radio" id="inActive" name="active" value="0"> Inactive
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

        $('select[name="service_id"]').on('change', function() {
          var serviceId = $(this).val();
          if(serviceId)
               {
                  $.ajax({
                     url : `/services/${serviceId}/variants`,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        $('select[name="variant_id"]').empty();
                        $.each(data, function(key,value){
                           $('select[name="variant_id"]').append('<option value="'+value.id+'">'+value.name+'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="variant_id"]').empty();
               }
      });
    </script>
@endpush
