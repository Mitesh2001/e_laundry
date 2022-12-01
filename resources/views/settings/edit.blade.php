@extends('layouts.app')

@section('content')
 <div class="container-fluid mt-5">
    <div class="col-sm-6 p-md-0  mt-2 mt-sm-0 d-flex">
        <a href="{{ url()->previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-lg-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Edit {{ $setting->title }}</h2>
                </div>
                <div class="card-body">
                    <x-form route="setting.update" updateId="{{ $setting->id }}" type="Submit" method="true">
                        <x-input name='title' placeholder="Title" value="{{ $setting->title }}"/>

                        <textarea class="form-control" id="editor" name="content" placeholder="Content">{{ $setting->content }}</textarea>
                    </x-form>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

    <script>
        $('#name').keyup(function() {
            $('#slug').val($(this).val().toLowerCase().split(',').join('').replace(/\s/g,"-"));
		});
    </script>
@endpush
