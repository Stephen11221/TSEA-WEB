@extends('admin.layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Welcome Back, {{ auth()->user()->name }}!</h1>
        <p class="page-subtitle">Here's your system overview for today</p>
    </div>
    <div class="btn-group">
        <button class="btn btn-primary" onclick="toggleDarkMode()">
            <i class="fas fa-moon"></i> Dark Mode
        </button>
        <button class="btn btn-secondary">
            <i class="fas fa-download"></i> Export
        </button>
    </div>
</div>

<!-- KPI Grid -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="kpi-value">{{ $totalUsers }}</div>
        <div class="kpi-label">Total Users</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> +{{ $newUsersThisMonth }} this month
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="kpi-value">{{ $activeUsers }}</div>
        <div class="kpi-label">Active Users</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> {{ $engagementRate }}% engagement
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon primary">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="kpi-value">{{ $totalStudents }}</div>
        <div class="kpi-label">Students</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> Active learners
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon primary">
            <i class="fas fa-building"></i>
        </div>
        <div class="kpi-value">{{ $totalEmployers }}</div>
        <div class="kpi-label">Employers</div>
        <div class="kpi-change change-positive">
            @if($pendingEmployers > 0)
                <i class="fas fa-alert"></i> {{ $pendingEmployers }} pending
            @else
                <i class="fas fa-check-circle"></i> All verified
            @endif
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon warning">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="kpi-value">{{ $totalJobs }}</div>
        <div class="kpi-label">Job Postings</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> {{ $activeJobs }} active
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div class="kpi-value">{{ $totalPrograms }}</div>
        <div class="kpi-label">Programs</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> {{ $programStats['published'] }} published
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon success">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="kpi-value">{{ $totalApplications }}</div>
        <div class="kpi-label">Applications</div>
        <div class="kpi-change change-positive">
            @if($pendingApplications > 0)
                <i class="fas fa-alert"></i> {{ $pendingApplications }} pending
            @else
                <i class="fas fa-check-circle"></i> All reviewed
            @endif
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon warning">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="kpi-value">{{ $totalAdmins }}</div>
        <div class="kpi-label">Administrators</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-shield-alt"></i> System admins
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Chart -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;">Monthly User Growth</h3>
        <canvas id="userGrowthChart"></canvas>
    </div>
    
    <!-- Program Status -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;">Program Status Breakdown</h3>
        <div style="display: grid; gap: 15px;">
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-weight: 500;">Published</span>
                    <span style="font-weight: 600; color: var(--color-primary);">{{ $programStats['published'] }}</span>
                </div>
                <div style="width: 100%; height: 8px; background-color: #f0f0f0; border-radius: 4px; overflow: hidden;">
                    <div style="width: {{ $totalPrograms > 0 ? ($programStats['published'] / $totalPrograms * 100) : 0 }}%; height: 100%; background-color: var(--color-secondary);"></div>
                </div>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-weight: 500;">Coming Soon</span>
                    <span style="font-weight: 600; color: var(--color-accent);">{{ $programStats['coming_soon'] }}</span>
                </div>
                <div style="width: 100%; height: 8px; background-color: #f0f0f0; border-radius: 4px; overflow: hidden;">
                    <div style="width: {{ $totalPrograms > 0 ? ($programStats['coming_soon'] / $totalPrograms * 100) : 0 }}%; height: 100%; background-color: var(--color-accent);"></div>
                </div>
            </div>
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-weight: 500;">Unavailable</span>
                    <span style="font-weight: 600; color: #999;">{{ $programStats['unavailable'] }}</span>
                </div>
                <div style="width: 100%; height: 8px; background-color: #f0f0f0; border-radius: 4px; overflow: hidden;">
                    <div style="width: {{ $totalPrograms > 0 ? ($programStats['unavailable'] / $totalPrograms * 100) : 0 }}%; height: 100%; background-color: #ddd;"></div>
                </div>
            </div>
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #e0e0e0;">
                <a href="{{ route('admin.programs.index') }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500;">
                    Manage Programs <i class="fas fa-arrow-right" style="margin-left: 6px;"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;">Recent Activities</h3>
    <table class="data-table" style="margin-bottom: 0;">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentActivities as $activity)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                {{ substr($activity['user'], 0, 1) }}
                            </div>
                            <span>{{ $activity['user'] }}</span>
                        </div>
                    </td>
                    <td>{{ $activity['action'] }}</td>
                    <td>{{ $activity['time'] }}</td>
                    <td><span class="badge badge-success">Success</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px;">No activities yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Quick Actions -->
<div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;">Quick Actions</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-user-plus"></i> Manage Students
        </a>
        <a href="{{ route('admin.employers.index') }}" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-building"></i> Manage Employers
        </a>
        <a href="{{ route('admin.programs.index') }}" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-tasks"></i> View Programs
        </a>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-file-alt"></i> Applications
        </a>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-briefcase"></i> Jobs
        </a>
    </div>
</div>

<script>
    // User Growth Chart
    const ctx = document.getElementById('userGrowthChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json(array_keys($monthlyStats)),
                datasets: [{
                    label: 'New Users',
                    data: @json(array_values($monthlyStats)),
                    borderColor: '#0066CC',
                    backgroundColor: 'rgba(0, 102, 204, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#0066CC',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
