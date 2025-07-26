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
                <a href="{{ route('feed-records.index') }}" class="menu-item active">
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
                        <div class="stat-label">Today's Feeding</div>
                        <div class="stat-value">{{ \App\Models\FeedRecord::where('user_id', auth()->id())->whereDate('feeding_date', today())->count() }}</div>
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
                                    <i class="fas fa-seedling me-2"></i>
                                    Feed Record Details
                                </h2>
                                <p class="page-subtitle">View feeding record for {{ $feedRecord->feeding_date->format('F j, Y') }}</p>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('feed-records.edit', $feedRecord->id) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Record
                                </a>
                                <a href="{{ route('feed-records.index') }}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-list me-2"></i>
                                    All Records
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feed Record Details -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-wheat-awn me-2"></i>Feeding Record Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- Feeding Date -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <label class="info-label">Feeding Date</label>
                                        <div class="info-value">
                                            <i class="fas fa-calendar-day me-2 text-primary"></i>
                                            {{ $feedRecord->feeding_date->format('l, F j, Y') }}
                                        </div>
                                        <div class="info-meta">
                                            {{ $feedRecord->feeding_date->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Cattle Information -->
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <label class="info-label">Cattle</label>
                                        <div class="info-value">
                                            <div class="d-flex align-items-center">
                                                <div class="cattle-avatar me-3">
                                                    <i class="fas fa-cow"></i>
                                                </div>
                                                <div>
                                                    <div class="cattle-tag">{{ $feedRecord->cattle->tag_number }}</div>
                                                    <div class="cattle-breed">{{ $feedRecord->cattle->name ?? 'N/A' }} - {{ ucfirst($feedRecord->cattle->breed) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feed Information -->
                                <div class="col-12">
                                    <div class="feed-breakdown">
                                        <h6 class="mb-3">Feed Details</h6>
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <div class="feed-card type">
                                                    <div class="feed-icon">
                                                        <i class="fas fa-wheat-awn"></i>
                                                    </div>
                                                    <div class="feed-details">
                                                        <div class="feed-label">Feed Type</div>
                                                        <div class="feed-value">{{ $feedRecord->feed_type }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="feed-card quantity">
                                                    <div class="feed-icon">
                                                        <i class="fas fa-weight-hanging"></i>
                                                    </div>
                                                    <div class="feed-details">
                                                        <div class="feed-label">Quantity</div>
                                                        <div class="feed-value">{{ number_format($feedRecord->quantity, 1) }} kg</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($feedRecord->cost_per_unit)
                                            <div class="col-md-3">
                                                <div class="feed-card cost">
                                                    <div class="feed-icon">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </div>
                                                    <div class="feed-details">
                                                        <div class="feed-label">Cost per Unit</div>
                                                        <div class="feed-value">${{ number_format($feedRecord->cost_per_unit, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if($feedRecord->total_cost)
                                            <div class="col-md-3">
                                                <div class="feed-card total">
                                                    <div class="feed-icon">
                                                        <i class="fas fa-calculator"></i>
                                                    </div>
                                                    <div class="feed-details">
                                                        <div class="feed-label">Total Cost</div>
                                                        <div class="feed-value">${{ number_format($feedRecord->total_cost, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes -->
                                @if($feedRecord->notes)
                                <div class="col-12">
                                    <div class="info-group">
                                        <label class="info-label">Notes</label>
                                        <div class="notes-content">
                                            {{ $feedRecord->notes }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Record Information -->
                                <div class="col-12">
                                    <div class="record-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-clock me-2"></i>
                                            Recorded on {{ $feedRecord->created_at->format('M j, Y \a\t g:i A') }}
                                        </div>
                                        @if($feedRecord->updated_at != $feedRecord->created_at)
                                        <div class="meta-item">
                                            <i class="fas fa-edit me-2"></i>
                                            Last updated {{ $feedRecord->updated_at->diffForHumans() }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('feed-records.index') }}" class="btn btn-light btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Records
                                </a>
                                <div class="btn-group">
                                    <a href="{{ route('feed-records.edit', $feedRecord->id) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-edit me-2"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('feed-records.destroy', $feedRecord->id) }}" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this feed record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-lg">
                                            <i class="fas fa-trash me-2"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script>
    // User dropdown toggle functionality
    function toggleUserDropdown() {
        const userInfo = document.getElementById('userInfo');
        const userDropdown = document.getElementById('userDropdown');
        
        userInfo.classList.toggle('active');
        userDropdown.classList.toggle('active');
    }

    function closeUserDropdown() {
        const userInfo = document.getElementById('userInfo');
        const userDropdown = document.getElementById('userDropdown');
        
        userInfo.classList.remove('active');
        userDropdown.classList.remove('active');
    }

    // Event listeners
    document.getElementById('userInfo').addEventListener('click', function(e) {
        e.stopPropagation();
        toggleUserDropdown();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-info') && !e.target.closest('.user-dropdown')) {
            closeUserDropdown();
        }
    });

    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('sidebarOverlay').classList.toggle('active');
    });

    document.getElementById('sidebarOverlay').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('sidebarOverlay').classList.remove('active');
    });
</script>

@include('layouts.sidebar-styles')

<style>
/* Additional styles for feed record details */
.info-group {
    margin-bottom: 1.5rem;
}

.info-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.9rem;
}

.info-value {
    font-size: 1rem;
    color: #333;
    display: flex;
    align-items: center;
}

.info-meta {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.cattle-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.cattle-tag {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.cattle-breed {
    font-size: 0.85rem;
    color: #6c757d;
}

.feed-breakdown {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin: 1rem 0;
}

.feed-card {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-left: 3px solid;
}

.feed-card.type { border-left-color: #28a745; }
.feed-card.quantity { border-left-color: #17a2b8; }
.feed-card.cost { border-left-color: #ffc107; }
.feed-card.total { border-left-color: #dc3545; }

.feed-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    font-size: 1rem;
}

.feed-card.type .feed-icon { background: rgba(40, 167, 69, 0.1); color: #28a745; }
.feed-card.quantity .feed-icon { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
.feed-card.cost .feed-icon { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
.feed-card.total .feed-icon { background: rgba(220, 53, 69, 0.1); color: #dc3545; }

.feed-label {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.feed-value {
    font-weight: 600;
    font-size: 1rem;
    color: #333;
}

.notes-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 3px solid #667eea;
    font-style: italic;
    color: #495057;
}

.record-meta {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.meta-item {
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
}

.meta-item:last-child {
    margin-bottom: 0;
}
</style>
@endsection
