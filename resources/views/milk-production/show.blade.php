@extends('layouts.app')

@section('content')
<div class="dashboard-layout">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    
   
    
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
                            Milk Production Details
                        </h2>
                        <p class="page-subtitle">Production record for {{ $milkProduction->production_date->format('F j, Y') }}</p>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('milk-production.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Records
                        </a>
                        <a href="{{ route('milk-production.edit', $milkProduction->id) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit me-2"></i>
                            Edit Record
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Details -->
        <div class="col-lg-8">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Production Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Date Information -->
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="info-label">Production Date</label>
                                <div class="info-value">
                                    <i class="fas fa-calendar-day me-2 text-primary"></i>
                                    {{ $milkProduction->production_date->format('l, F j, Y') }}
                                </div>
                                <div class="info-meta">
                                    {{ $milkProduction->production_date->diffForHumans() }}
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
                                            <div class="cattle-tag">{{ $milkProduction->cattle->tag_number }}</div>
                                            <div class="cattle-breed">{{ ucfirst($milkProduction->cattle->breed) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Production Breakdown -->
                        <div class="col-12">
                            <div class="production-breakdown">
                                <h6 class="mb-3">Production Breakdown</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="production-card morning">
                                            <div class="production-icon">
                                                <i class="fas fa-sun"></i>
                                            </div>
                                            <div class="production-details">
                                                <div class="production-label">Morning</div>
                                                <div class="production-amount">{{ number_format($milkProduction->morning_milk, 1) }}L</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="production-card evening">
                                            <div class="production-icon">
                                                <i class="fas fa-moon"></i>
                                            </div>
                                            <div class="production-details">
                                                <div class="production-label">Evening</div>
                                                <div class="production-amount">{{ number_format($milkProduction->evening_milk, 1) }}L</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="production-card total">
                                            <div class="production-icon">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div class="production-details">
                                                <div class="production-label">Total</div>
                                                <div class="production-amount">{{ number_format($milkProduction->total_milk, 1) }}L</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($milkProduction->notes)
                        <div class="col-12">
                            <div class="info-group">
                                <label class="info-label">Notes</label>
                                <div class="notes-content">
                                    {{ $milkProduction->notes }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Record Information -->
                        <div class="col-12">
                            <div class="record-meta">
                                <div class="meta-item">
                                    <i class="fas fa-clock me-2"></i>
                                    Recorded on {{ $milkProduction->created_at->format('M j, Y \a\t g:i A') }}
                                </div>
                                @if($milkProduction->updated_at != $milkProduction->created_at)
                                <div class="meta-item">
                                    <i class="fas fa-edit me-2"></i>
                                    Last updated {{ $milkProduction->updated_at->diffForHumans() }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="{{ route('milk-production.edit', $milkProduction->id) }}" class="action-btn edit">
                            <i class="fas fa-edit"></i>
                            <span>Edit Record</span>
                        </a>
                        <a href="{{ route('milk-production.create') }}" class="action-btn add">
                            <i class="fas fa-plus"></i>
                            <span>Add New Record</span>
                        </a>
                        <form method="POST" action="{{ route('milk-production.destroy', $milkProduction->id) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete">
                                <i class="fas fa-trash"></i>
                                <span>Delete Record</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cattle Stats -->
            <div class="farmer-card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-cow me-2"></i>{{ $milkProduction->cattle->tag_number }} Stats</h5>
                </div>
                <div class="card-body">
                    @php
                        $cattleStats = \App\Models\MilkProduction::where('cattle_id', $milkProduction->cattle_id)
                            ->where('user_id', auth()->id())
                            ->selectRaw('
                                COUNT(*) as total_records,
                                AVG(total_milk) as avg_daily,
                                MAX(total_milk) as max_daily,
                                SUM(total_milk) as total_production
                            ')
                            ->first();
                    @endphp
                    
                    <div class="cattle-stats">
                        <div class="stat-row">
                            <span class="stat-label">Total Records</span>
                            <span class="stat-value">{{ $cattleStats->total_records }}</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Average Daily</span>
                            <span class="stat-value">{{ number_format($cattleStats->avg_daily, 1) }}L</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Best Day</span>
                            <span class="stat-value">{{ number_format($cattleStats->max_daily, 1) }}L</span>
                        </div>
                        <div class="stat-row">
                            <span class="stat-label">Total Production</span>
                            <span class="stat-value">{{ number_format($cattleStats->total_production, 1) }}L</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Records for this Cattle -->
            <div class="farmer-card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-history me-2"></i>Recent Records</h5>
                </div>
                <div class="card-body">
                    @php
                        $recentRecords = \App\Models\MilkProduction::where('cattle_id', $milkProduction->cattle_id)
                            ->where('user_id', auth()->id())
                            ->where('id', '!=', $milkProduction->id)
                            ->latest('production_date')
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @forelse($recentRecords as $record)
                    <div class="recent-record">
                        <div class="record-date">{{ $record->production_date->format('M j') }}</div>
                        <div class="record-amount">{{ number_format($record->total_milk, 1) }}L</div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-info-circle mb-2"></i>
                        <p>No other records for this cattle</p>
                    </div>
                    @endforelse
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
/* Hide navbar for this page */
.navbar {
    display: none !important;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 0;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    opacity: 0.9;
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

.info-group {
    margin-bottom: 1.5rem;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.5rem;
    display: block;
}

.info-value {
    font-size: 1.1rem;
    font-weight: 500;
    color: #495057;
}

.info-meta {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.cattle-avatar {
    width: 50px;
    height: 50px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.cattle-tag {
    font-weight: 700;
    font-size: 1.1rem;
    color: #495057;
}

.cattle-breed {
    color: #6c757d;
    font-size: 0.9rem;
}

.production-breakdown {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 15px;
}

.production-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 10px;
    color: white;
}

.production-card.morning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.production-card.evening {
    background: linear-gradient(135deg, #6f42c1, #d63384);
}

.production-card.total {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.production-icon {
    font-size: 1.5rem;
}

.production-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.production-amount {
    font-size: 1.5rem;
    font-weight: 700;
}

.notes-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.record-meta {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.meta-item {
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.meta-item:last-child {
    margin-bottom: 0;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%;
}

.action-btn.edit {
    background: #ffc107;
    color: #212529;
}

.action-btn.add {
    background: #28a745;
    color: white;
}

.action-btn.delete {
    background: #dc3545;
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    color: inherit;
}

.cattle-stats, .stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.stat-row:last-child {
    border-bottom: none;
}

.stat-label {
    color: #6c757d;
}

.stat-value {
    font-weight: 700;
    color: #495057;
}

.recent-record {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.recent-record:last-child {
    border-bottom: none;
}

.record-date {
    color: #6c757d;
}

.record-amount {
    font-weight: 700;
    color: #28a745;
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
    
    .btn-group {
        flex-direction: column;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .production-breakdown .row {
        gap: 0.75rem;
    }
}
</style>
@endsection
