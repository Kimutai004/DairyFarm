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
            <div class="user-info" id="userInfo">
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
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </div>
            
            <!-- User Dropdown Menu -->
            <div class="user-dropdown" id="userDropdown">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-question-circle"></i>
                    <span>Help & Support</span>
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-title">Dashboard</div>
                <a href="{{ route('home') }}" class="menu-item">
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
                <a href="{{ route('milk-production.index') }}" class="menu-item active">
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
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="page-title">
                            <i class="fas fa-glass-whiskey me-2"></i>
                            Milk Production Records
                        </h2>
                        <p class="page-subtitle">Track and manage daily milk production</p>
                    </div>
                    <a href="{{ route('milk-production.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        Record Production
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->where('production_date', today())->sum('total_milk'), 1) }}L</h3>
                    <p>Today's Production</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->where('production_date', '>=', now()->startOfWeek())->sum('total_milk'), 1) }}L</h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->where('production_date', '>=', now()->startOfMonth())->sum('total_milk'), 1) }}L</h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->avg('total_milk'), 1) }}L</h3>
                    <p>Average Daily</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Production Records -->
    <div class="row">
        <div class="col-12">
            <div class="farmer-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-list me-2"></i>Production Records</h5>
                        <div class="card-tools">
                            <form method="GET" class="d-flex">
                                <input type="date" name="date" class="form-control me-2" 
                                       value="{{ request('date') }}" placeholder="Filter by date">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($milkProductions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cattle</th>
                                    <th>Morning (L)</th>
                                    <th>Evening (L)</th>
                                    <th>Total (L)</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($milkProductions as $production)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $production->production_date->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $production->production_date->format('l') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="cattle-avatar me-2">
                                                <i class="fas fa-cow"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ $production->cattle->tag_number }}</span>
                                                <br>
                                                <small class="text-muted">{{ ucfirst($production->cattle->breed) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($production->morning_milk, 1) }}L</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ number_format($production->evening_milk, 1) }}L</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success fs-6">{{ number_format($production->total_milk, 1) }}L</span>
                                    </td>
                                    <td>
                                        {{ Str::limit($production->notes, 30) }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('milk-production.show', $production->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('milk-production.edit', $production->id) }}" 
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('milk-production.destroy', $production->id) }}" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $milkProductions->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-glass-whiskey fa-3x text-muted mb-3"></i>
                        <h5>No milk production records yet</h5>
                        <p class="text-muted">Start by recording your first milk production.</p>
                        <a href="{{ route('milk-production.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Record First Production
                        </a>
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
    const userInfo = document.getElementById('userInfo');
    const userDropdown = document.getElementById('userDropdown');
    
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
    
    function toggleUserDropdown() {
        userInfo.classList.toggle('active');
        userDropdown.classList.toggle('active');
    }
    
    function closeUserDropdown() {
        userInfo.classList.remove('active');
        userDropdown.classList.remove('active');
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    if (userInfo) {
        userInfo.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleUserDropdown();
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!userInfo.contains(e.target) && !userDropdown.contains(e.target)) {
            closeUserDropdown();
        }
    });
    
    // Close sidebar on window resize if mobile
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
});
</script>

<!-- Hidden logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 0;
}

.page-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
}

.page-subtitle {
    opacity: 0.9;
    margin: 0;
    font-size: 0.9rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
    border-left: 3px solid;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-card.primary { border-left-color: #667eea; }
.stat-card.success { border-left-color: #28a745; }
.stat-card.warning { border-left-color: #ffc107; }
.stat-card.info { border-left-color: #17a2b8; }

.stat-card .stat-icon {
    font-size: 1.6rem;
    margin-bottom: 0.8rem;
    color: #6c757d;
}

.stat-card h3 {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
    color: #333;
}

.stat-card p {
    color: #6c757d;
    margin: 0;
    font-size: 0.85rem;
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

.cattle-avatar {
    width: 35px;
    height: 35px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.85rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.btn-group .btn {
    border-radius: 6px !important;
    margin-right: 2px;
    padding: 0.5rem 0.8rem;
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
        padding: 1.2rem;
    }
    
    .card-tools {
        margin-top: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endsection
