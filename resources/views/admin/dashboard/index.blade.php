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
            <i class="fas fa-arrow-up"></i> 92% engagement
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon warning">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="kpi-value">{{ $totalJobs ?? 0 }}</div>
        <div class="kpi-label">Job Postings</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> {{ $activeJobs ?? 0 }} active
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div class="kpi-value">{{ $totalCourses ?? 0 }}</div>
        <div class="kpi-label">Courses</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> {{ $activeCourses ?? 0 }} published
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon success">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="kpi-value">{{ $totalApplications ?? 0 }}</div>
        <div class="kpi-label">Applications</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-alert"></i> {{ $pendingApplications ?? 0 }} pending
        </div>
    </div>
    
    <div class="kpi-card">
        <div class="kpi-icon warning">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="kpi-value">${{ number_format($totalRevenue ?? 0, 0) }}</div>
        <div class="kpi-label">Total Revenue</div>
        <div class="kpi-change change-positive">
            <i class="fas fa-arrow-up"></i> +15% vs last month
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Chart -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;">Monthly User Growth</h3>
        <canvas id="userGrowthChart"></canvas>
    </div>
    
    <!-- System Status -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 20px; font-size: 16px; font-weight: 600;">System Status</h3>
        <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>API Response</span>
                <span class="badge badge-success">Healthy</span>
            </div>
            <div style="width: 100%; height: 6px; background-color: #f0f0f0; border-radius: 3px; overflow: hidden;">
                <div style="width: 95%; height: 100%; background-color: var(--color-secondary);"></div>
            </div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">95% uptime</div>
        </div>
        
        <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e0e0e0;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>Database</span>
                <span class="badge badge-success">Connected</span>
            </div>
            <div style="width: 100%; height: 6px; background-color: #f0f0f0; border-radius: 3px; overflow: hidden;">
                <div style="width: 99%; height: 100%; background-color: var(--color-secondary);"></div>
            </div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">99% uptime</div>
        </div>
        
        <div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span>Storage</span>
                <span class="badge badge-warning">40% Used</span>
            </div>
            <div style="width: 100%; height: 6px; background-color: #f0f0f0; border-radius: 3px; overflow: hidden;">
                <div style="width: 40%; height: 100%; background-color: var(--color-accent);"></div>
            </div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">4GB of 10GB</div>
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
            <i class="fas fa-user-plus"></i> Manage Users
        </a>
        <a href="#" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-briefcase"></i> Post Job
        </a>
        <a href="#" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-book"></i> Create Course
        </a>
        <a href="#" class="btn btn-primary" style="justify-content: center;">
            <i class="fas fa-file-alt"></i> View Applications
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
