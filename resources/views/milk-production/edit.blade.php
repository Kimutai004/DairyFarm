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
                            <i class="fas fa-edit me-2"></i>
                            Edit Milk Production
                        </h2>
                        <p class="page-subtitle">Update production record for {{ $milkProduction->production_date->format('F j, Y') }}</p>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('milk-production.show', $milkProduction->id) }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Details
                        </a>
                        <a href="{{ route('milk-production.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-list me-2"></i>
                            All Records
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-glass-whiskey me-2"></i>Update Production Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('milk-production.update', $milkProduction->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Production Date -->
                            <div class="col-md-6">
                                <label for="production_date" class="form-label">Production Date</label>
                                <input id="production_date" type="date" class="form-control @error('production_date') is-invalid @enderror" 
                                       name="production_date" value="{{ old('production_date', $milkProduction->production_date->format('Y-m-d')) }}" required>
                                @error('production_date')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Cattle Selection -->
                            <div class="col-md-6">
                                <label for="cattle_id" class="form-label">Select Cattle</label>
                                <select id="cattle_id" class="form-select @error('cattle_id') is-invalid @enderror" name="cattle_id" required>
                                    <option value="">Choose cattle...</option>
                                    @foreach($cattle as $cow)
                                        <option value="{{ $cow->id }}" {{ (old('cattle_id', $milkProduction->cattle_id) == $cow->id) ? 'selected' : '' }}>
                                            {{ $cow->tag_number }} - {{ ucfirst($cow->breed) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cattle_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Morning Milk -->
                            <div class="col-md-6">
                                <label for="morning_milk" class="form-label">Morning Milk (Liters)</label>
                                <div class="input-group">
                                    <input id="morning_milk" type="number" step="0.1" min="0" 
                                           class="form-control @error('morning_milk') is-invalid @enderror" 
                                           name="morning_milk" value="{{ old('morning_milk', $milkProduction->morning_milk) }}" required
                                           placeholder="0.0">
                                    <span class="input-group-text">L</span>
                                </div>
                                @error('morning_milk')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Evening Milk -->
                            <div class="col-md-6">
                                <label for="evening_milk" class="form-label">Evening Milk (Liters)</label>
                                <div class="input-group">
                                    <input id="evening_milk" type="number" step="0.1" min="0" 
                                           class="form-control @error('evening_milk') is-invalid @enderror" 
                                           name="evening_milk" value="{{ old('evening_milk', $milkProduction->evening_milk) }}" required
                                           placeholder="0.0">
                                    <span class="input-group-text">L</span>
                                </div>
                                @error('evening_milk')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Total Display -->
                            <div class="col-md-12">
                                <div class="total-display">
                                    <label class="form-label">Total Daily Production</label>
                                    <div class="total-amount">
                                        <span id="total_milk">{{ number_format($milkProduction->total_milk, 1) }}</span> L
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes (Optional)</label>
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          name="notes" rows="3" placeholder="Any additional notes about today's production...">{{ old('notes', $milkProduction->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Update Production Record
                            </button>
                            <a href="{{ route('milk-production.show', $milkProduction->id) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar with Current vs New Comparison -->
        <div class="col-lg-4">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar me-2"></i>Current Record</h5>
                </div>
                <div class="card-body">
                    <div class="current-record">
                        <div class="record-detail">
                            <span class="detail-label">Date</span>
                            <span class="detail-value">{{ $milkProduction->production_date->format('M j, Y') }}</span>
                        </div>
                        <div class="record-detail">
                            <span class="detail-label">Cattle</span>
                            <span class="detail-value">{{ $milkProduction->cattle->tag_number }}</span>
                        </div>
                        <div class="record-detail">
                            <span class="detail-label">Morning</span>
                            <span class="detail-value">{{ number_format($milkProduction->morning_milk, 1) }}L</span>
                        </div>
                        <div class="record-detail">
                            <span class="detail-label">Evening</span>
                            <span class="detail-value">{{ number_format($milkProduction->evening_milk, 1) }}L</span>
                        </div>
                        <div class="record-detail total">
                            <span class="detail-label">Total</span>
                            <span class="detail-value">{{ number_format($milkProduction->total_milk, 1) }}L</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Editing Tips -->
            <div class="farmer-card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-lightbulb me-2"></i>Editing Tips</h5>
                </div>
                <div class="card-body">
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check text-success me-2"></i>
                            Double-check milk quantities for accuracy
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check text-success me-2"></i>
                            Ensure the correct cattle is selected
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check text-success me-2"></i>
                            Add notes for any unusual observations
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check text-success me-2"></i>
                            Verify the production date is correct
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Records for Context -->
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
                        <div class="record-amounts">
                            <span class="morning">{{ number_format($record->morning_milk, 1) }}L</span>
                            <span class="evening">{{ number_format($record->evening_milk, 1) }}L</span>
                            <span class="total">{{ number_format($record->total_milk, 1) }}L</span>
                        </div>
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

    // Auto-calculate total milk production
    const morningInput = document.getElementById('morning_milk');
    const eveningInput = document.getElementById('evening_milk');
    const totalDisplay = document.getElementById('total-display');

    function updateTotal() {
        const morning = parseFloat(morningInput.value) || 0;
        const evening = parseFloat(eveningInput.value) || 0;
        const total = morning + evening;
        totalDisplay.textContent = total.toFixed(1);
    }

    if (morningInput && eveningInput && totalDisplay) {
        morningInput.addEventListener('input', updateTotal);
        eveningInput.addEventListener('input', updateTotal);
        
        // Initialize total on page load
        updateTotal();
    }
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

.total-display {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 1.5rem;
    border-radius: 15px;
    text-align: center;
}

.total-display .form-label {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0.5rem;
}

.total-amount {
    font-size: 2.5rem;
    font-weight: 700;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.current-record {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.record-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.record-detail:last-child {
    border-bottom: none;
}

.record-detail.total {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 10px;
    font-weight: 700;
}

.detail-label {
    color: #6c757d;
    font-weight: 500;
}

.detail-value {
    color: #495057;
    font-weight: 600;
}

.tips-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tip-item {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
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
    font-weight: 500;
}

.record-amounts {
    display: flex;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.record-amounts .morning {
    color: #ffc107;
}

.record-amounts .evening {
    color: #6f42c1;
}

.record-amounts .total {
    color: #28a745;
    font-weight: 700;
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
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const morningInput = document.getElementById('morning_milk');
    const eveningInput = document.getElementById('evening_milk');
    const totalDisplay = document.getElementById('total_milk');

    function updateTotal() {
        const morning = parseFloat(morningInput.value) || 0;
        const evening = parseFloat(eveningInput.value) || 0;
        const total = morning + evening;
        totalDisplay.textContent = total.toFixed(1);
    }

    morningInput.addEventListener('input', updateTotal);
    eveningInput.addEventListener('input', updateTotal);
});
</script>
@endsection
