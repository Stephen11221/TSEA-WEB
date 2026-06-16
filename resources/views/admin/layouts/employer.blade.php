<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title', 'Employer Hub') - TSEA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e40af;
            --brand-blue: #3b82f6;
            --light-blue: #eff6ff;
            --card-radius: 16px;
            --sidebar-width: 280px;
            --form-radius: 12px;
        }

        body { background-color: var(--light-blue); color: #1e293b; }
        .dashboard-wrapper { display: flex; min-height: 100vh; }

        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            color: white;
            flex-shrink: 0;
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-header { padding: 2rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .brand-text { font-weight: 800; letter-spacing: -0.5px; margin: 0; }
        .sidebar-nav { padding: 0.5rem 1rem; flex: 1; }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-item i { width: 20px; margin-right: 12px; font-size: 1.1rem; }
        .nav-item:hover, .nav-item.active { background-color: rgba(255,255,255,0.1); color: white; }
        .nav-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 1.5rem 0; }

        .main-content { flex: 1; background-color: var(--light-blue); overflow-x: hidden; display: flex; flex-direction: column; }
        .content-header { background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }

        @media (max-width: 991.98px) {
            .sidebar { position: fixed; left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { left: 0; }
        }

        .stat-card { border-radius: var(--card-radius) !important; transition: transform 0.2s ease, box-shadow 0.2s ease; border: none !important; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.15) !important; }
        .stat-label { color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
        .stat-value { font-weight: 800; font-size: 1.75rem; color: #0f172a; }
        .main-table-card { border-radius: var(--card-radius); overflow: hidden; }

        .table thead th { 
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; 
            color: var(--primary-blue); background-color: #f8fafc; border-bottom: 2px solid #f1f5f9; padding: 1rem;
        }

        .badge { font-weight: 600; font-size: 0.7rem; padding: 0.55em 1em; letter-spacing: 0.3px; }
        .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1) !important; color: #198754 !important; }
        .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1) !important; color: #6c757d !important; }

        .btn-group .btn { 
            border-radius: 8px !important; margin: 0 2px; width: 34px; height: 34px;
            display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease; border: 1px solid #e2e8f0;
        }
        .btn-group .btn:hover { transform: translateY(-2px); background-color: #f8fafc; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

        .form-label { font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: var(--form-radius); padding: 0.625rem 0.75rem; border: 1px solid #e2e8f0; transition: all 0.2s ease; }
        .form-control:focus, .form-select:focus { border-color: var(--brand-blue); box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
        .btn-primary { background: linear-gradient(135deg, var(--primary-blue) 0%, var(--brand-blue) 100%); border: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(30, 64, 175, 0.3); }
    </style>
</head>
<body>
    
    <div class="dashboard-wrapper">
        <aside class="sidebar" id="employerSidebar">
            <div class="sidebar-header">
                <h4 class="brand-text">Employer Hub</h4>
                <button class="btn d-lg-none text-white border-0" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('employer.jobs.index') }}" class="nav-item {{ request()->routeIs('employer.jobs.index') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> My Jobs
                </a>
                <a href="{{ route('employer.jobs.create') }}" class="nav-item {{ request()->routeIs('employer.jobs.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i> Post New Job
                </a>
                <a href="{{ route('employer.applications.index') }}" class="nav-item {{ request()->routeIs('employer.applications.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> Applications
                </a>
                <div class="nav-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="mt-auto"> {{-- Added mt-auto for consistent spacing --}}
                    @csrf
                    <button type="submit" class="nav-item text-danger bg-transparent border-0 w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>
        <div class="main-content">
            <header class="content-header">
                <button class="btn btn-light d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-bold d-none d-md-block text-primary">TSEA Workspace</h5>
                <div class="header-profile">
                    <span class="me-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eff6ff&color=1e40af" alt="Profile" class="rounded-circle shadow-sm" width="35">
                </div>
            </header>
            <main class="py-4 px-3 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>


    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('employerSidebar').classList.add('active');
        });
        document.getElementById('sidebarClose')?.addEventListener('click', function() {
            document.getElementById('employerSidebar').classList.remove('active');
        });
    </script>
</body>
</html>