<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased main-container">
    <nav id="main-nav" class="flex-container">
            <a href="/">Home</a>
            <a href="/search">Search</a>
            <a href="/wishlist">Wishlist</a>
            <a href="/library">Library</a>
            @if (!Auth::user())
            <a href="/register">Register</a>
            <a href="/login">Login</a>
            @else
            <a href="/user/profile">Profile</a>
            @endif
        </nav>
        @inertia
    </body>
</html>