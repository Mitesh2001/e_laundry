@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-xl-12 col-xxl-12 col-lg-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Send Notifications</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('notify.users') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="users">Users</label>
                            <select class="custom-select" name="users" >
                                <option selected>select user</option>
                                <option value="all_users">All Users</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notification_content">Notification Content</label>
                            <textarea class="form-control" id="notification_content" name="notification_content" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Notify User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
