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
                <a href="{{ route('feed-records.index') }}" class="menu-item">
                    <i class="fas fa-wheat-awn"></i>
                    <span>Feed Records</span>
                </a>
                <a href="{{ route('feed-records.create') }}" class="menu-item active">
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
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="page-title">
                                    <i class="fas fa-seedling me-2"></i>
                                    New Feed Record
                                </h2>
                                <p class="page-subtitle">Record feeding session for cattle</p>
                            </div>
                            <a href="{{ route('feed-records.index') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Records
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-wheat-awn me-2"></i>Feed Record Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('feed-records.store') }}">
                                @csrf

                                <div class="row g-3">
                                    <!-- Cattle Selection -->
                                    <div class="col-md-6">
                                        <label for="cattle_id" class="form-label">Select Cattle *</label>
                                        <select id="cattle_id" class="form-select @error('cattle_id') is-invalid @enderror" name="cattle_id" required>
                                            <option value="">Choose cattle...</option>
                                            @foreach($cattle as $cow)
                                                <option value="{{ $cow->id }}" {{ old('cattle_id') == $cow->id ? 'selected' : '' }}>
                                                    {{ $cow->tag_number }} - {{ $cow->name }} ({{ ucfirst($cow->breed) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cattle_id')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Feeding Date -->
                                    <div class="col-md-6">
                                        <label for="feeding_date" class="form-label">Feeding Date *</label>
                                        <input id="feeding_date" type="date" class="form-control @error('feeding_date') is-invalid @enderror" 
                                               name="feeding_date" value="{{ old('feeding_date', date('Y-m-d')) }}" required>
                                        @error('feeding_date')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Feed Type -->
                                    <div class="col-md-6">
                                        <label for="feed_type" class="form-label">Feed Type *</label>
                                        <select id="feed_type" class="form-select @error('feed_type') is-invalid @enderror" name="feed_type" required>
                                            <option value="">Select feed type...</option>
                                            <option value="Hay" {{ old('feed_type') == 'Hay' ? 'selected' : '' }}>Hay</option>
                                            <option value="Silage" {{ old('feed_type') == 'Silage' ? 'selected' : '' }}>Silage</option>
                                            <option value="Grain" {{ old('feed_type') == 'Grain' ? 'selected' : '' }}>Grain</option>
                                            <option value="Corn" {{ old('feed_type') == 'Corn' ? 'selected' : '' }}>Corn</option>
                                            <option value="Pasture" {{ old('feed_type') == 'Pasture' ? 'selected' : '' }}>Pasture</option>
                                            <option value="Supplements" {{ old('feed_type') == 'Supplements' ? 'selected' : '' }}>Supplements</option>
                                            <option value="Concentrate" {{ old('feed_type') == 'Concentrate' ? 'selected' : '' }}>Concentrate</option>
                                            <option value="Mineral Mix" {{ old('feed_type') == 'Mineral Mix' ? 'selected' : '' }}>Mineral Mix</option>
                                        </select>
                                        @error('feed_type')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label">Quantity *</label>
                                        <input id="quantity" type="number" step="0.1" min="0" 
                                               class="form-control @error('quantity') is-invalid @enderror" 
                                               name="quantity" value="{{ old('quantity') }}" required
                                               placeholder="0.0">
                                        @error('quantity')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div class="col-md-6">
                                        <label for="unit" class="form-label">Unit *</label>
                                        <select id="unit" class="form-select @error('unit') is-invalid @enderror" name="unit" required>
                                            <option value="">Select unit...</option>
                                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                            <option value="lbs" {{ old('unit') == 'lbs' ? 'selected' : '' }}>Pounds (lbs)</option>
                                            <option value="tons" {{ old('unit') == 'tons' ? 'selected' : '' }}>Tons</option>
                                            <option value="bags" {{ old('unit') == 'bags' ? 'selected' : '' }}>Bags</option>
                                            <option value="bales" {{ old('unit') == 'bales' ? 'selected' : '' }}>Bales</option>
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Cost per Unit -->
                                    <div class="col-md-6">
                                        <label for="cost_per_unit" class="form-label">Cost per Unit ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input id="cost_per_unit" type="number" step="0.01" min="0" 
                                                   class="form-control @error('cost_per_unit') is-invalid @enderror" 
                                                   name="cost_per_unit" value="{{ old('cost_per_unit') }}"
                                                   placeholder="0.00">
                                        </div>
                                        @error('cost_per_unit')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Total Cost -->
                                    <div class="col-md-6">
                                        <label for="total_cost" class="form-label">Total Cost ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input id="total_cost" type="number" step="0.01" min="0" 
                                                   class="form-control @error('total_cost') is-invalid @enderror" 
                                                   name="total_cost" value="{{ old('total_cost') }}"
                                                   placeholder="0.00" readonly>
                                        </div>
                                        @error('total_cost')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        <div class="form-text">Will be calculated automatically or enter manually</div>
                                    </div>

                                    <!-- Enable Manual Cost -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="manual_cost">
                                            <label class="form-check-label" for="manual_cost">
                                                Enter total cost manually (override calculation)
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Additional Notes</label>
                                        <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                  name="notes" rows="4"
                                                  placeholder="Any additional information about this feeding session...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>
                                        Save Feed Record
                                    </button>
                                    <a href="{{ route('feed-records.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times me-2"></i>
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar with Information -->
                <div class="col-lg-4">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle me-2"></i>Feeding Tips</h5>
                        </div>
                        <div class="card-body">
                            <div class="tips-list">
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Record exact quantities for proper nutrition tracking
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Monitor feed costs to optimize farm expenses
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Note any feed quality or cattle behavior
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Maintain consistent feeding schedules
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Feeding Stats -->
                    <div class="farmer-card mt-3">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-bar me-2"></i>Today's Feeding</h5>
                        </div>
                        <div class="card-body">
                            <div class="stats-list">
                                <div class="stat-item">
                                    <div class="stat-label">Records Today</div>
                                    <div class="stat-value">{{ \App\Models\FeedRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereDate('feeding_date', today())->count() }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">Total Quantity</div>
                                    <div class="stat-value">{{ number_format(\App\Models\FeedRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereDate('feeding_date', today())->sum('quantity'), 1) }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">Total Cost</div>
                                    <div class="stat-value">${{ number_format(\App\Models\FeedRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereDate('feeding_date', today())->sum('total_cost'), 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($cattle->count() == 0)
                    <div class="farmer-card mt-3">
                        <div class="card-header">
                            <h5><i class="fas fa-exclamation-triangle me-2 text-warning"></i>No Cattle Available</h5>
                        </div>
                        <div class="card-body">
                            <p>You need to add cattle before recording feed records.</p>
                            <a href="{{ route('cattle.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Add Cattle
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.sidebar-styles')

<style>
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
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

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.stat-label {
    font-weight: 500;
    color: #6c757d;
}

.stat-value {
    font-weight: 700;
    color: #495057;
}

@media (max-width: 768px) {
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

    // Auto-calculate total cost
    const quantityInput = document.getElementById('quantity');
    const costPerUnitInput = document.getElementById('cost_per_unit');
    const totalCostInput = document.getElementById('total_cost');
    const manualCostCheckbox = document.getElementById('manual_cost');

    function calculateTotalCost() {
        if (!manualCostCheckbox.checked) {
            const quantity = parseFloat(quantityInput.value) || 0;
            const costPerUnit = parseFloat(costPerUnitInput.value) || 0;
            const totalCost = quantity * costPerUnit;
            totalCostInput.value = totalCost.toFixed(2);
        }
    }

    quantityInput.addEventListener('input', calculateTotalCost);
    costPerUnitInput.addEventListener('input', calculateTotalCost);
    
    manualCostCheckbox.addEventListener('change', function() {
        if (this.checked) {
            totalCostInput.readOnly = false;
            totalCostInput.focus();
        } else {
            totalCostInput.readOnly = true;
            calculateTotalCost();
        }
    });
});
</script>
@endsection
