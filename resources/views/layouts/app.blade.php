<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web/fav-icon/eLaundry.svg') }}">
    <title>{{ env('APP_NAME') }}</title>
    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('web/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('web/css/custom.css') }}" type="text/css">

</head>
<body>

    <div class="preload">
        <div class="flexbox">
            <div>
                <img src="{{ asset('images/loader/rzinsoft-loader.gif') }}" alt="">
            </div>
        </div>
    </div>

    @include('layouts.partials.sidebar')

    <div class="main-content">

        @yield('content')

    </div>

    <script src="{{ asset('web/js/jquery.min.js') }}"></script>
    <script src="{{ asset('web/js/popper.js') }}"></script>
    <script src="{{ asset('web/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('web/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('web/js/argon.js') }}"></script>
    <script src="{{ asset('web/js/main.js') }}"></script>

    @if (session('visitor'))
    <script>
        Swal.fire(
            'You are visitor.',
            'Sorry, you can\'t anything create, update and delete.',
            'question'
            )
    </script>
    @endif

    @stack('scripts')
</body>
</html>
