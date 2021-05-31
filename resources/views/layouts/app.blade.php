<!doctype html>
<html lang="en" class="bg-neon-extraDark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content='@json(auth()->user())'>
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="user-name" content="{{ auth()->user()->name ?? '' }}">
    <meta name="user-email" content="{{ auth()->user()->email ?? '' }}">
    <meta name="description" content="A Neon Forum">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @yield('criticalCss')

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

    @yield('head')

</head>
<body class="font-display">
<div id="app">
    <nav style="min-height: 64px;">
        <navbar></navbar>
    </nav>

    @yield('content')

    <flash message="{{ session('flash') }}"></flash>
</div>

<!-- Scripts -->
<script src="{{ mix('/js/app.js') }}" async defer></script>

@yield('scripts')

</body>
</html>
