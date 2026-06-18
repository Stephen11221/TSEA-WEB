@php
    $variant = $variant ?? 'compact';
    $logoFile = 'images/logo.jpeg';
@endphp

<a @class(['brand-mark', 'brand-mark-full' => $variant === 'full'])
   href="{{ route('home') }}"
   aria-label="TSEA home">

    <img
        src="{{ asset($logoFile) }}"
        alt="TSEA - Taifa Skills & Employability Academy"
        class="h-20 w-auto object-contain border-0 outline-none shadow-none rounded-none"
        style="border:none; outline:none; box-shadow:none;"
    >
</a>