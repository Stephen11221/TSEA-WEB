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

<style>
    .site-header {
        background-color: #0B1D33; /* Primary Corporate Navy */
        color: #ffffff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .nav-links a {
        color: rgba(255, 255, 255, 0.7) !important;
        transition: color 0.3s ease;
    }

    .nav-links a:hover, 
    .nav-links a.active {
        color: #ffffff !important;
    }

    .user-name {
        color: #ffffff;
    }

    .nav-toggle i {
        color: #ffffff;
    }

    /* Styles for btn-gold (yellow button) */
    .btn-gold{
        background:#FFC107; /* Primary Gold */
        color:#0B1D33; /* Dark navy for high contrast text */
        border:none;
        padding:10px 18px;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
        transition: all 0.3s ease;
    }

    .btn-gold:hover{
        background:#E6B000; /* Slightly darker gold on hover */
    }
</style>
