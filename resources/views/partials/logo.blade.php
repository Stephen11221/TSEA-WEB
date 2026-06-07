@php
    $variant = $variant ?? 'compact';
    $logoFile = 'images/logo.jpeg';     
@endphp

<a @class(['brand-mark', 'brand-mark-full' => $variant === 'full']) href="{{ route('home') }}" aria-label="TSEA home">
    <img src="{{ asset($logoFile) }}" alt="TSEA - Taifa Skills & Employability Academy"  class=" md:h-20 w-auto object-contain"
>
</a>
