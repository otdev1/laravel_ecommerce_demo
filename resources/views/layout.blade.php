<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Ecommerce | @yield('title', '')</title>

        <link href="/img/favicon.ico" rel="SHORTCUT ICON" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

        <script src="{{ asset('js/app.js') }}" defer></script>

        @yield('extra-css')
    </head>


<body class="@yield('body-class', '')">
    {{--@include('partials.nav')--}}
    
    @include('partials.customnav')

    @yield('content')

    {{--@include('partials.footer')--}}

    @stack('scripts') 
    {{--see 
            push directive in cart.blade.php
            https://laravel.com/docs/5.8/blade#stacks 
            https://stackoverflow.com/questions/55963663/laravel-custom-javascript-on-blade-is-not-working/55963744
    --}}

    @yield('extra-js')


</body>
</html>
