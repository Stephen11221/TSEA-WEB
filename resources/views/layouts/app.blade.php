<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'TSEA is Africa’s Workforce Passport for skills, identity and opportunity.')">
    <title>@yield('title', 'TSEA - Taifa Skills & Employability Academy')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    @include('partials.navbar')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
