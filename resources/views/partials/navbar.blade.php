@php
    $navItems = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'Workforce Passport™', 'route' => 'passport'],
        ['label' => 'ERI™', 'route' => 'eri'],
        ['label' => 'Programs', 'route' => 'programs'],
        ['label' => 'Employers', 'route' => 'employers'],
        ['label' => 'Institutions', 'route' => 'institutions'],
        ['label' => 'Workforce Intelligence™', 'route' => 'intelligence'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Contact', 'route' => 'contact'],
    ];
@endphp

<header class="site-header">
    <nav class="nav-shell" aria-label="Main navigation">
        @include('partials.logo')
        <button class="nav-toggle" type="button" aria-label="Open navigation" aria-expanded="false" data-nav-toggle>
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <div class="nav-panel" data-nav-panel>
            <ul class="nav-links">
                @foreach ($navItems as $item)
                    <li>
                        <a href="{{ route($item['route']) }}" @class(['active' => request()->routeIs($item['route'])])>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="nav-actions">
                <a class="btn btn-primary btn-sm" href="{{ route('passport.create') }}">Create Passport</a>
                <a class="profile-button" href="{{ route('passport') }}" aria-label="View profile">
                    <i class="fas fa-user" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </nav>
</header>
