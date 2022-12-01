@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-lg-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ $setting->title }}</h2>
                </div>
                <div class="card-body">
                    {!! $setting->content !!}
                   <div class="mt-4 text-right">
                        <a href="{{ route('setting.edit', $setting->slug) }}" class="btn btn-primary">Edit</a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
