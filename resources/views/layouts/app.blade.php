<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SpaceX') }}</title>

    <!-- Styles -->
    @include('layouts.head-links')
    <style>
        .moveInUp-enter-active{
        animation: fadeIn 0.7s ease-in;
        }
        @keyframes fadeIn{
        0%{
            opacity: 0;
        }
        50%{
            opacity: 0.5;
        }
        100%{
            opacity: 1;
        }
        }

        @media (max-width: 767px) {
            .navbar-nav {
                flex-direction: initial;
            }
            .navbar-expand-md .navbar-nav .nav-link {
                padding-right: 0.5rem;
                padding-left: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        {{-- @include ('layouts.nav') --}}

        @yield('content')

    </div>

    <!-- Scripts -->
    @include ('layouts.footer-links')
</body>

</html>
