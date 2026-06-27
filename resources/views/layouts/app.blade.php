<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
        $appCss = $manifest['resources/css/app.css']['file'] ?? null;
        $appJs = $manifest['resources/js/app.js']['file'] ?? null;
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'TSEA is Africa’s Workforce Passport for skills, identity and opportunity.')">
    <title>@yield('title', 'TSEA - Taifa Skills & Employability Academy')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @if ($appCss)
        <link rel="stylesheet" href="{{ asset('build/' . $appCss) }}">
    @endif
    @if ($appJs)
        <script type="module" src="{{ asset('build/' . $appJs) }}"></script>
    @endif
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
