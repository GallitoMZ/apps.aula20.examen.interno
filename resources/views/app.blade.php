<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Aula 20') }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">

    <meta name="msapplication-TileColor" content="#000a3b">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#000a3b">
    <meta name="description" content="Academia Aula 20, somos una academia preuniversitaria que forma estudiantes de alto nivel para el ingreso universitario, con la metodología Integral 20." />
    <meta name="keywords" content="Aula 20, academia preuniversitaria, ingreso a universidades, alto rendimiento académico, formación cultural, metodología Integral 20, preparación universitaria, estudiantes destacados, educación integral, academia en Perú">


    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased text-gray-100 bg-aula20-950 min-h-screen selection:bg-aula20-500 selection:text-white overflow-x-hidden">

    <div class="fixed inset-0 -z-50 h-full w-full bg-aula20-950">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_-20%,var(--color-aula20-600),transparent_60%)] opacity-40"></div>

        <div class="absolute inset-0 bg-[url('/assets/img/FondoMain.svg')] bg-repeat opacity-20 mix-blend-overlay"></div>

        <div class="absolute bottom-0 right-0 w-125 h-125 bg-secondary-600/20 blur-[100px] rounded-full translate-y-1/3 translate-x-1/3"></div>

        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <div class="relative z-0 flex flex-col min-h-screen">
        @inertia
    </div>

</body>

</html>
