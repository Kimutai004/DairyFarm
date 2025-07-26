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
                <a href="{{ route('health-records.create') }}" class="menu-item active">
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
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="page-title">
                                    <i class="fas fa-stethoscope me-2"></i>
                                    New Health Record
                                </h2>
                                <p class="page-subtitle">Record health checkup for cattle</p>
                            </div>
                            <a href="{{ route('health-records.index') }}" class="btn btn-light btn-lg">
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
                            <h5><i class="fas fa-heartbeat me-2"></i>Health Record Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('health-records.store') }}">
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

                                    <!-- Checkup Date -->
                                    <div class="col-md-6">
                                        <label for="checkup_date" class="form-label">Checkup Date *</label>
                                        <input id="checkup_date" type="date" class="form-control @error('checkup_date') is-invalid @enderror" 
                                               name="checkup_date" value="{{ old('checkup_date', date('Y-m-d')) }}" required>
                                        @error('checkup_date')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Checkup Type -->
                                    <div class="col-md-6">
                                        <label for="checkup_type" class="form-label">Checkup Type *</label>
                                        <select id="checkup_type" class="form-select @error('checkup_type') is-invalid @enderror" name="checkup_type" required>
                                            <option value="">Select type...</option>
                                            <option value="Routine Checkup" {{ old('checkup_type') == 'Routine Checkup' ? 'selected' : '' }}>Routine Checkup</option>
                                            <option value="Vaccination" {{ old('checkup_type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                            <option value="Treatment" {{ old('checkup_type') == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                                            <option value="Emergency" {{ old('checkup_type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                            <option value="Pregnancy Check" {{ old('checkup_type') == 'Pregnancy Check' ? 'selected' : '' }}>Pregnancy Check</option>
                                            <option value="Deworming" {{ old('checkup_type') == 'Deworming' ? 'selected' : '' }}>Deworming</option>
                                        </select>
                                        @error('checkup_type')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Veterinarian -->
                                    <div class="col-md-6">
                                        <label for="veterinarian" class="form-label">Veterinarian</label>
                                        <input id="veterinarian" type="text" class="form-control @error('veterinarian') is-invalid @enderror" 
                                               name="veterinarian" value="{{ old('veterinarian') }}"
                                               placeholder="Dr. Johnson">
                                        @error('veterinarian')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Symptoms -->
                                    <div class="col-12">
                                        <label for="symptoms" class="form-label">Symptoms Observed</label>
                                        <textarea id="symptoms" class="form-control @error('symptoms') is-invalid @enderror" 
                                                  name="symptoms" rows="3"
                                                  placeholder="Describe any symptoms or concerns observed...">{{ old('symptoms') }}</textarea>
                                        @error('symptoms')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Diagnosis -->
                                    <div class="col-12">
                                        <label for="diagnosis" class="form-label">Diagnosis</label>
                                        <textarea id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" 
                                                  name="diagnosis" rows="3"
                                                  placeholder="Veterinarian's diagnosis...">{{ old('diagnosis') }}</textarea>
                                        @error('diagnosis')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Treatment -->
                                    <div class="col-md-6">
                                        <label for="treatment" class="form-label">Treatment Given</label>
                                        <textarea id="treatment" class="form-control @error('treatment') is-invalid @enderror" 
                                                  name="treatment" rows="4"
                                                  placeholder="Describe treatment provided...">{{ old('treatment') }}</textarea>
                                        @error('treatment')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Medication -->
                                    <div class="col-md-6">
                                        <label for="medication" class="form-label">Medication Prescribed</label>
                                        <textarea id="medication" class="form-control @error('medication') is-invalid @enderror" 
                                                  name="medication" rows="4"
                                                  placeholder="List medications and dosages...">{{ old('medication') }}</textarea>
                                        @error('medication')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Next Checkup Date -->
                                    <div class="col-md-6">
                                        <label for="next_checkup_date" class="form-label">Next Checkup Date</label>
                                        <input id="next_checkup_date" type="date" class="form-control @error('next_checkup_date') is-invalid @enderror" 
                                               name="next_checkup_date" value="{{ old('next_checkup_date') }}">
                                        @error('next_checkup_date')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Cost -->
                                    <div class="col-md-6">
                                        <label for="cost" class="form-label">Cost ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input id="cost" type="number" step="0.01" min="0" 
                                                   class="form-control @error('cost') is-invalid @enderror" 
                                                   name="cost" value="{{ old('cost') }}"
                                                   placeholder="0.00">
                                        </div>
                                        @error('cost')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Additional Notes</label>
                                        <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                  name="notes" rows="3"
                                                  placeholder="Any additional observations or notes...">{{ old('notes') }}</textarea>
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
                                        Save Health Record
                                    </button>
                                    <a href="{{ route('health-records.index') }}" class="btn btn-secondary btn-lg">
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
                            <h5><i class="fas fa-info-circle me-2"></i>Health Record Tips</h5>
                        </div>
                        <div class="card-body">
                            <div class="tips-list">
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Record all symptoms accurately
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Include veterinarian contact details
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Set follow-up checkup dates
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Keep track of treatment costs
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
                            <p>You need to add cattle before recording health records.</p>
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
});
</script>
@endsection
