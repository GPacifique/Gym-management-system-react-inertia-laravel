<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- App Title --}}
    <title inertia>{{ config('app.name', 'Fitness SaaS') }}</title>

    {{-- CSRF Token (required for Inertia forms) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Theme Color (optional SaaS polish) --}}
    <meta name="theme-color" content="#2563eb">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
@routes
    {{-- Vite (React entry) --}}
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])

    {{-- Inertia Head --}}
    @inertiaHead
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">

    {{-- Inertia Root App --}}
    @inertia

</body>

</html>