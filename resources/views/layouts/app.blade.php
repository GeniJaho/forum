<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content='@json(auth()->user())'>
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="user-name" content="{{ auth()->user()->name ?? '' }}">
    <meta name="user-email" content="{{ auth()->user()->email ?? '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @yield('head')

</head>
<body>
<div id="app">
    <navbar></navbar>

    @yield('content')

    <flash message="{{ session('flash') }}"></flash>
</div>

@yield('scripts')

</body>
</html>
