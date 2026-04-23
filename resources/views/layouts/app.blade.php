<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic page title with fallback --}}
    <title>@yield('title', 'NovaTech Portal')</title>

    {{-- Global theme stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    {{-- CSRF token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    {{-- Sidebar visible for both guests and authenticated users --}}
    @include('partials.sidebar')

    <div class="main-wrapper">

        {{-- Topbar only for authenticated users --}}
        @auth
            @include('partials.header')
        @endauth

        {{-- 
            Fade-in is DISABLED on pages that redirect immediately:
            - login
            - register
            - create project
            - edit project
        --}}
        @php
            $disableFade = request()->is('login')
                || request()->is('register')
                || request()->is('projects/create')
                || request()->is('projects/*/edit');
        @endphp

        <main class="content @yield('containerClass') {{ $disableFade ? '' : 'fade-in' }}" role="main">

            {{-- Success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- First validation / error message --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Page-specific content --}}
            @yield('content')

        </main>

    </div>

</body>
</html>
