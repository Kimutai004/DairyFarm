@extends('layouts.app')

@section('content')
<!-- Mobile Sidebar Toggle -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="dashboard-layout">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="farm-logo">
                <i class="fas fa-cow"></i>
                <span>DairyFarm Pro</span>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Farm Manager</div>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-title">Dashboard</div>
                <a href="{{ route('home') }}" class="menu-item active">
                    <i class="fas fa-home"></i>
                    <span>Overview</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Livestock</div>
                <a href="{{ route('cattle.index') }}" class="menu-item">
                    <i class="fas fa-cow"></i>
                    <span>My Cattle</span>
                    <span class="menu-badge">{{ \App\Models\Cattle::where('user_id', auth()->id())->count() }}</span>
                </a>
                <a href="{{ route('cattle.create') }}" class="menu-item">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Cattle</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Production</div>
                <a href="{{ route('milk-production.index') }}" class="menu-item">
                    <i class="fas fa-glass-whiskey"></i>
                    <span>Milk Records</span>
                </a>
                <a href="{{ route('milk-production.create') }}" class="menu-item">
                    <i class="fas fa-plus"></i>
                    <span>Record Production</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Health & Care</div>
                <a href="{{ route('health-records.index') }}" class="menu-item">
                    <i class="fas fa-heartbeat"></i>
                    <span>Health Records</span>
                </a>
                <a href="{{ route('health-records.create') }}" class="menu-item">
                    <i class="fas fa-stethoscope"></i>
                    <span>Health Check</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Feeding</div>
                <a href="{{ route('feed-records.index') }}" class="menu-item">
                    <i class="fas fa-wheat-awn"></i>
                    <span>Feed Records</span>
                </a>
                <a href="{{ route('feed-records.create') }}" class="menu-item">
                    <i class="fas fa-seedling"></i>
                    <span>Record Feeding</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-title">Breeding</div>
                <a href="{{ route('breeding-records.index') }}" class="menu-item">
                    <i class="fas fa-heart"></i>
                    <span>Breeding Records</span>
                </a>
                <a href="{{ route('breeding-records.create') }}" class="menu-item">
                    <i class="fas fa-venus-mars"></i>
                    <span>Record Breeding</span>
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="quick-stats">
                <div class="quick-stat">
                    <div class="stat-icon primary">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Today's Milk</div>
                        <div class="stat-value">{{ number_format(\App\Models\MilkProduction::where('user_id', auth()->id())->whereDate('production_date', today())->sum('total_milk'), 1) }}L</div>
                    </div>
                </div>
                
                <div class="quick-stat">
                    <div class="stat-icon success">
                        <i class="fas fa-cow"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Active Cattle</div>
                        <div class="stat-value">{{ \App\Models\Cattle::where('user_id', auth()->id())->where('status', 'active')->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="sidebar-actions">
                <a href="{{ route('logout') }}" class="action-link" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
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
                    <h3>{{ \App\Models\Cattle::where('user_id', auth()->id())->count() }}</h3>
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
                    <h3>{{ \App\Models\HealthRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->where('next_checkup_date', '>=', today())->where('next_checkup_date', '<=', today()->addDays(7))->count() }}</h3>
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
                        <a href="{{ route('milk-production.create') }}" class="action-btn primary">
                            <i class="fas fa-plus-circle"></i>
                            <span>Record Milk Production</span>
                        </a>
                        <a href="{{ route('health-records.create') }}" class="action-btn success">
                            <i class="fas fa-heartbeat"></i>
                            <span>Health Check</span>
                        </a>
                        <a href="{{ route('feed-records.create') }}" class="action-btn warning">
                            <i class="fas fa-wheat-awn"></i>
                            <span>Feed Record</span>
                        </a>
                        <a href="{{ route('milk-production.index') }}" class="action-btn info">
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
                        $myCattle = \App\Models\Cattle::where('user_id', auth()->id())->take(6)->get();
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
    </div>
</div>

@include('layouts.sidebar-styles')

<script>
// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
    }
    
    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar on window resize if mobile
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
});
</script>

<style>
/* Dashboard specific styles */
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 0;
}

.welcome-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
}

.welcome-subtitle {
    opacity: 0.9;
    margin: 0;
    font-size: 0.9rem;
}

.date-info {
    text-align: center;
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem;
    border-radius: 8px;
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
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    border: none;
}

.farmer-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0;
    padding: 1rem 1.25rem;
}

.farmer-card .card-body {
    padding: 1.25rem;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.8rem;
    background: #f8f9fa;
    border: 2px solid transparent;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    font-size: 0.85rem;
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
    gap: 0.8rem;
    padding: 0.8rem 0;
    border-bottom: 1px solid #e9ecef;
    font-size: 0.85rem;
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

    // Sidebar functionality for mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar && sidebarOverlay) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // Close sidebar when clicking menu items on mobile
        const menuItems = sidebar.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
        });
    }

    // Add smooth scrolling to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endsection
