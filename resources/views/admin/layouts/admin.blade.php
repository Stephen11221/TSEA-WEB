<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - TSEA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --color-primary: #0066CC;
            --color-secondary: #00B359;
            --color-accent: #FF6B35;
            --color-dark: #1a1a1a;
            --color-light: #F8F9FA;
            --color-border: #E0E0E0;
            --color-text: #333333;
            --color-text-muted: #666666;
            --sidebar-width: 260px;
            --topbar-height: 60px;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--color-light);
            color: var(--color-text);
            line-height: 1.6;
        }
        
        body.dark-mode {
            background-color: var(--color-dark);
            color: #ffffff;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: #ffffff;
            border-right: 1px solid var(--color-border);
            overflow-y: auto;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .admin-sidebar {
            background: #2a2a2a;
            border-right-color: #444;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--color-border);
            text-align: center;
        }
        
        .sidebar-logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--color-primary);
            text-decoration: none;
            display: block;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-section {
            margin-bottom: 20px;
        }
        
        .nav-section-title {
            padding: 10px 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--color-text-muted);
            letter-spacing: 0.5px;
        }
        
        body.dark-mode .nav-section-title {
            color: #999;
        }
        
        .nav-item {
            margin: 5px 10px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--color-text);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        body.dark-mode .nav-link {
            color: #e0e0e0;
        }
        
        .nav-link:hover {
            background-color: rgba(0, 102, 204, 0.1);
            color: var(--color-primary);
        }
        
        .nav-link.active {
            background-color: rgba(0, 102, 204, 0.15);
            color: var(--color-primary);
            border-right: 4px solid var(--color-primary);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }
        
        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
        }
        
        /* Top Bar */
        .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--color-border);
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: var(--topbar-height);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        body.dark-mode .admin-topbar {
            background: #2a2a2a;
            border-bottom-color: #444;
        }
        
        .topbar-search {
            flex: 1;
            max-width: 400px;
        }
        
        .topbar-search input {
            width: 100%;
            padding: 8px 16px;
            border: 1px solid var(--color-border);
            border-radius: 6px;
            font-size: 14px;
            background-color: var(--color-light);
        }
        
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: 30px;
        }
        
        .notification-icon, .user-menu-toggle {
            font-size: 18px;
            color: var(--color-text);
            cursor: pointer;
            position: relative;
            border: none;
            background: none;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .notification-icon,
        body.dark-mode .user-menu-toggle {
            color: #e0e0e0;
        }
        
        .notification-icon:hover,
        .user-menu-toggle:hover {
            color: var(--color-primary);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            background-color: var(--color-accent);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }
        
        /* Content Area */
        .admin-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-text);
        }
        
        body.dark-mode .page-title {
            color: #ffffff;
        }
        
        .page-subtitle {
            font-size: 14px;
            color: var(--color-text-muted);
            margin-top: 5px;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0052A3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,102,204,0.3);
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: var(--color-text);
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        body.dark-mode .btn-secondary {
            background-color: #444;
            color: #e0e0e0;
        }
        
        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .kpi-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        body.dark-mode .kpi-card {
            background: #2a2a2a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .kpi-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .kpi-icon.primary { background-color: rgba(0,102,204,0.1); color: var(--color-primary); }
        .kpi-icon.success { background-color: rgba(0,179,89,0.1); color: var(--color-secondary); }
        .kpi-icon.warning { background-color: rgba(255,107,53,0.1); color: var(--color-accent); }
        
        .kpi-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 5px;
        }
        
        body.dark-mode .kpi-value {
            color: #ffffff;
        }
        
        .kpi-label {
            font-size: 14px;
            color: var(--color-text-muted);
        }
        
        .kpi-change {
            font-size: 12px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--color-border);
        }
        
.change-positive { color: var(--color-secondary); }
.change-negative { color: var(--color-text-muted); }
        
        /* Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        body.dark-mode .data-table {
            background: #2a2a2a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        
        .data-table thead {
            background-color: var(--color-light);
            border-bottom: 2px solid var(--color-border);
        }
        
        body.dark-mode .data-table thead {
            background-color: #1a1a1a;
            border-bottom-color: #444;
        }
        
        .data-table th {
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            color: var(--color-text-muted);
            letter-spacing: 0.5px;
        }
        
        .data-table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--color-border);
        }
        
        body.dark-mode .data-table td {
            border-bottom-color: #444;
            color: #e0e0e0;
        }
        
        .data-table tbody tr:hover {
            background-color: rgba(0,102,204,0.05);
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success { background-color: rgba(0,179,89,0.2); color: var(--color-secondary); }
        .badge-warning { background-color: rgba(255,107,53,0.2); color: var(--color-accent); }
        .badge-danger { background-color: rgba(102,102,102,0.2); color: var(--color-text-muted); }
        .badge-info { background-color: rgba(0,102,204,0.2); color: var(--color-primary); }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                z-index: 2000;
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
                width: 100%;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .kpi-grid {
                grid-template-columns: 1fr;
            }
            
            .topbar-search {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i> TSEA
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Web-page view</div>
                    <a href="{{ route('home') }}" class="nav-link">View update</a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.employers.index') }}" class="nav-link @if(request()->routeIs('admin.employers.*')) active @endif">
                            <i class="fas fa-building"></i>
                            <span>Employers</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.contact.submissions') }}" class="nav-link @if(request()->routeIs('admin.contact.submissions')) active @endif">
                            <i class="fas fa-inbox"></i>
                            <span>Contact Submissions</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-briefcase"></i>
                            <span>Job Postings</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>Courses</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            <span>Applications</span>
                        </a>
                    </div>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Operations</div>

                    <div  class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.content.program*') ? 'active' : '' }}" 
                        href="{{ route('admin.content.program') }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Programs</span>
                        </a>
                    </div>  
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.content.eri*') ? 'active' : '' }}"
                        href="{{ route('admin.content.eri') }}">
                            <i class="fas fa-chart-line"></i>
                            <span>ERI <sup>tm</sup></span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('admin.content.workforce-passport') }}"
                        class="nav-link {{ request()->routeIs('admin.content.workforce-passport*') ? 'active' : '' }}">
                            <i class="fas fa-id-card"></i>
                            <span>Workforce Passport</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.content.homepage') }}"
                        class="nav-link {{ request()->routeIs('admin.content.homepage*') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Homepage Content</span>
                        </a>

                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.content.about') }}"
                            class="nav-link {{ request()->routeIs('admin.content.about') ? 'active' : '' }}">
                            <i class="fas fa-info-circle me-2"></i>
                            About Page
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.content.contact') }}"
                            class="nav-link {{ request()->routeIs('admin.content.contact*') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i>
                            <span>Contact Us</span>
                        </a>
                    </div>
                </div>
                
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Bar -->
            <header class="admin-topbar">
                <div class="topbar-search">
                    <input type="text" placeholder="Search..." id="globalSearch">
                </div>
                <div class="topbar-actions">
                    <button class="notification-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="user-menu-toggle" id="userMenuToggle">
                        <i class="fas fa-user-circle"></i>
                    </button>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // Sidebar toggle
        document.querySelectorAll('.sidebar-nav .nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-nav .nav-item').forEach(i => 
                    i.querySelector('.nav-link').classList.remove('active')
                );
                this.querySelector('.nav-link').classList.add('active');
            });
        });
        
        // Theme toggle
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        }
        
        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>
