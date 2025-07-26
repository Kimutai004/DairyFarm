@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="welcome-title">Welcome, {{ auth()->user()->name }}! 🌾</h2>
                        <p class="welcome-subtitle">Your personal dairy farm dashboard</p>
                    </div>
                    <div class="date-info">
                        <div class="current-date">{{ date('l, F j, Y') }}</div>
                        <div class="current-time" id="farmerTime"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="farmer-stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-cow"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ \App\Models\Cattle::where('assigned_to', auth()->id())->count() }}</h3>
                    <p>My Cattle</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="farmer-stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-glass-whiskey"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format(\App\Models\MilkProduction::where('user_id', auth()->id())->whereDate('production_date', today())->sum('total_milk'), 1) }}L</h3>
                    <p>Today's Milk</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="farmer-stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ \App\Models\HealthRecord::whereHas('cattle', function($q) { $q->where('assigned_to', auth()->id()); })->where('next_checkup_date', '>=', today())->where('next_checkup_date', '<=', today()->addDays(7))->count() }}</h3>
                    <p>Upcoming Tasks</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="farmer-stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <h3>${{ number_format(\App\Models\Sale::where('user_id', auth()->id())->whereMonth('sale_date', now()->month)->sum('total_amount'), 0) }}</h3>
                    <p>Monthly Earnings</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-tasks me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="#" class="action-btn primary">
                            <i class="fas fa-plus-circle"></i>
                            <span>Record Milk Production</span>
                        </a>
                        <a href="#" class="action-btn success">
                            <i class="fas fa-heartbeat"></i>
                            <span>Health Check</span>
                        </a>
                        <a href="#" class="action-btn warning">
                            <i class="fas fa-wheat-awn"></i>
                            <span>Feed Record</span>
                        </a>
                        <a href="#" class="action-btn info">
                            <i class="fas fa-chart-line"></i>
                            <span>View Reports</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-clock me-2"></i>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        @php
                            $recentActivities = \App\Models\MilkProduction::where('user_id', auth()->id())
                                ->latest('production_date')
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-glass-whiskey"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Milk Production Recorded</h6>
                                <p>{{ $activity->total_milk }}L from {{ $activity->cattle->tag_number ?? 'cattle' }}</p>
                                <small>{{ $activity->production_date->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Welcome to your dashboard!</h6>
                                <p>Start by recording your daily milk production</p>
                                <small>Get started today</small>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Cattle Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-cow me-2"></i>My Cattle</h5>
                </div>
                <div class="card-body">
                    @php
                        $myCattle = \App\Models\Cattle::where('assigned_to', auth()->id())->take(6)->get();
                    @endphp
                    
                    @if($myCattle->count() > 0)
                    <div class="cattle-grid">
                        @foreach($myCattle as $cattle)
                        <div class="cattle-card">
                            <div class="cattle-info">
                                <h6>{{ $cattle->tag_number }}</h6>
                                <p>{{ ucfirst($cattle->breed) }}</p>
                                <span class="status-badge {{ $cattle->status }}">{{ ucfirst($cattle->status) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-cow fa-3x text-muted mb-3"></i>
                        <h5>No cattle assigned yet</h5>
                        <p class="text-muted">Contact your administrator to get cattle assigned to you.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 0;
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    opacity: 0.9;
    margin: 0;
}

.date-info {
    text-align: center;
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem;
    border-radius: 10px;
    backdrop-filter: blur(10px);
}

.current-date {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.current-time {
    font-size: 1.2rem;
    font-weight: 700;
}

.farmer-stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    border-left: 4px solid;
}

.farmer-stat-card:hover {
    transform: translateY(-5px);
}

.farmer-stat-card.primary { border-left-color: #667eea; }
.farmer-stat-card.success { border-left-color: #28a745; }
.farmer-stat-card.warning { border-left-color: #ffc107; }
.farmer-stat-card.info { border-left-color: #17a2b8; }

.farmer-stat-card .stat-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #6c757d;
}

.farmer-stat-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #333;
}

.farmer-stat-card p {
    color: #6c757d;
    margin: 0;
}

.farmer-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
}

.farmer-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 15px 15px 0 0;
    padding: 1rem 1.5rem;
}

.farmer-card .card-body {
    padding: 1.5rem;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: #f8f9fa;
    border: 2px solid transparent;
    border-radius: 10px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.action-btn:hover {
    color: white;
    text-decoration: none;
}

.action-btn.primary:hover { background: #667eea; }
.action-btn.success:hover { background: #28a745; }
.action-btn.warning:hover { background: #ffc107; }
.action-btn.info:hover { background: #17a2b8; }

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.activity-content h6 {
    margin: 0 0 0.25rem;
    font-weight: 600;
}

.activity-content p {
    margin: 0 0 0.25rem;
    color: #6c757d;
}

.cattle-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.cattle-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    text-align: center;
}

.cattle-info h6 {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.cattle-info p {
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.inactive {
    background: #f8d7da;
    color: #721c24;
}

@media (max-width: 768px) {
    .welcome-card {
        text-align: center;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .cattle-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

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
        const timeElement = document.getElementById('farmerTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    updateTime();
    setInterval(updateTime, 1000);
});
</script>
@endsection
