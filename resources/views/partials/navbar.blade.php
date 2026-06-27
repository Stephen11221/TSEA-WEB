@php
    $navItems = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
                    
        ['label' => 'Workforce Passport™', 'route' => 'passport'],
        ['label' => 'ERI™', 'route' => 'eri'],
        ['label' => 'Programs', 'route' => 'programs'],
        ['label' => 'Employers', 'route' => 'employers'],
        ['label' => 'Institutions', 'route' => 'institutions'],
        ['label' => 'Workforce Intelligence™', 'route' => 'intelligence'],
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
                @auth
                    <div class="user-menu">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        @if (auth()->user()->isAdmin())
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        @else
                            <a class="btn btn-primary btn-sm" href="{{ route('user.dashboard') }}">Student Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
                        </form>
                    </div>
                @else
                    <a class="btn btn-gold btn-sm" href="{{ route('programs') }}">Apply</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>
</header>
