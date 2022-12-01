@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="w-100">
                        <h2 class="float-left">Add New Customer</h2>
                        <div class="text-right">
                            <a class="btn btn-light" href="{{ route('customer.index') }}"> Back </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data"> @csrf
                        <div class="row">
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">First name <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First name">
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">Last name <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">Mobile number <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">Password <strong class="text-danger">*</strong></label>
                                <input type="password" class="form-control" name="password" placeholder="******">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-2">
                                <label for="">Confirm password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="******">
                            </div>
                            <div class="col-12 col-md-6 mb-2 py-2">
                                <label for="">Customr Photo</label>
                                <input type="file" class="form-control-file" name="profile_photo">
                            </div>

                            <div class="col-12 col-md-6 mb-2 py-2">
                                <label for=""></label>
                                <button class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
