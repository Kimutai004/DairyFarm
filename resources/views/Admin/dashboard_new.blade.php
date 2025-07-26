@extends('admin.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="welcome-title">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                <p class="welcome-subtitle">Here's what's happening with your dairy farm today.</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="date-widget">
                    <div class="current-date">{{ date('l, F j, Y') }}</div>
                    <div class="current-time" id="current-time"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-cow"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $totalCattle }}</h3>
                    <p class="stat-label">Total Cattle</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12% from last month</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-glass-whiskey"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ number_format($todayMilk, 1) }}L</h3>
                    <p class="stat-label">Today's Milk Production</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+8% from yesterday</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-syringe"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $upcomingVaccinations ?? 5 }}</h3>
                    <p class="stat-label">Upcoming Vaccinations</p>
                    <div class="stat-trend">
                        <i class="fas fa-clock"></i>
                        <span>Next 7 days</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-info">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number">{{ $totalFarmers }}</h3>
                    <p class="stat-label">Total Employees</p>
                    <div class="stat-trend">
                        <i class="fas fa-user-plus"></i>
                        <span>2 new this month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="row g-4 mb-5">
        <div class="col-xl-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Milk Production Trend</h5>
                    <div class="chart-controls">
                        <select class="form-select form-select-sm" id="productionPeriod">
                            <option value="7">Last 7 days</option>
                            <option value="30">Last 30 days</option>
                            <option value="90">Last 3 months</option>
                        </select>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="milkProductionChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Cattle Distribution</h5>
                </div>
                <div class="chart-body">
                    <canvas id="cattleDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Recent Activity -->
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="action-card">
                <div class="action-header">
                    <h5 class="action-title">Quick Actions</h5>
                </div>
                <div class="action-grid">
                    <a href="{{ route('admin.employees.create') }}" class="action-item">
                        <div class="action-icon bg-primary">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="action-content">
                            <h6>Add Employee</h6>
                            <p>Register new farmer</p>
                        </div>
                    </a>
                    
                    <a href="#" class="action-item">
                        <div class="action-icon bg-success">
                            <i class="fas fa-cow"></i>
                        </div>
                        <div class="action-content">
                            <h6>Add Cattle</h6>
                            <p>Register new cattle</p>
                        </div>
                    </a>
                    
                    <a href="#" class="action-item">
                        <div class="action-icon bg-warning">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div class="action-content">
                            <h6>Schedule Vaccination</h6>
                            <p>Plan health care</p>
                        </div>
                    </a>
                    
                    <a href="#" class="action-item">
                        <div class="action-icon bg-info">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="action-content">
                            <h6>View Reports</h6>
                            <p>Analyze performance</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="activity-card">
                <div class="activity-header">
                    <h5 class="activity-title">Recent Activity</h5>
                    <a href="#" class="view-all-link">View All</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="fas fa-cow"></i>
                        </div>
                        <div class="activity-content">
                            <h6>New cattle registered</h6>
                            <p>Holstein cow #C001 added to the farm</p>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="fas fa-glass-whiskey"></i>
                        </div>
                        <div class="activity-content">
                            <h6>Milk production recorded</h6>
                            <p>Morning collection: 245L from 15 cattle</p>
                            <small class="text-muted">5 hours ago</small>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="activity-content">
                            <h6>Vaccination reminder</h6>
                            <p>5 cattle due for vaccination this week</p>
                            <small class="text-muted">1 day ago</small>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon bg-info">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h6>New employee added</h6>
                            <p>John Doe joined as Farm Manager</p>
                            <small class="text-muted">2 days ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-container {
    padding: 0;
}

.welcome-section {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.welcome-title {
    color: #1a1a1a;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    color: #6b7280;
    font-size: 1.1rem;
    margin: 0;
}

.date-widget {
    text-align: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.current-date {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.25rem;
}

.current-time {
    font-size: 1.2rem;
    font-weight: 700;
    color: #4f46e5;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
}

.stat-card-primary::before { background: linear-gradient(90deg, #4f46e5, #7c3aed); }
.stat-card-success::before { background: linear-gradient(90deg, #059669, #10b981); }
.stat-card-warning::before { background: linear-gradient(90deg, #d97706, #f59e0b); }
.stat-card-info::before { background: linear-gradient(90deg, #0284c7, #0ea5e9); }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.stat-card-primary .stat-icon { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
.stat-card-success .stat-icon { background: linear-gradient(135deg, #059669, #10b981); }
.stat-card-warning .stat-icon { background: linear-gradient(135deg, #d97706, #f59e0b); }
.stat-card-info .stat-icon { background: linear-gradient(135deg, #0284c7, #0ea5e9); }

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0.75rem;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #059669;
}

.chart-card, .action-card, .activity-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    height: 100%;
}

.chart-header, .action-header, .activity-header {
    padding: 1.5rem 1.5rem 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-title, .action-title, .activity-title {
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.chart-body {
    padding: 1.5rem;
    height: 300px;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    padding: 1.5rem;
}

.action-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 15px;
    background: rgba(248, 249, 250, 0.8);
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.action-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
    color: inherit;
}

.action-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.action-content h6 {
    margin: 0 0 0.25rem;
    font-weight: 600;
}

.action-content p {
    margin: 0;
    font-size: 0.875rem;
    color: #6b7280;
}

.activity-list {
    padding: 0 1.5rem 1.5rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.activity-content h6 {
    margin: 0 0 0.25rem;
    font-weight: 600;
    font-size: 0.95rem;
}

.activity-content p {
    margin: 0 0 0.25rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.view-all-link {
    color: #4f46e5;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
}

.view-all-link:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .action-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour12: true,
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('current-time').textContent = timeString;
    }
    
    updateTime();
    setInterval(updateTime, 1000);

    // Initialize charts
    initializeMilkProductionChart();
    initializeCattleDistributionChart();
});

function initializeMilkProductionChart() {
    const ctx = document.getElementById('milkProductionChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Milk Production (L)',
                data: [245, 260, 238, 275, 290, 268, 285],
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

function initializeCattleDistributionChart() {
    const ctx = document.getElementById('cattleDistributionChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Holstein', 'Jersey', 'Friesian', 'Others'],
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: [
                    '#4f46e5',
                    '#059669',
                    '#d97706',
                    '#0284c7'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
}
</script>
@endpush
@endsection
