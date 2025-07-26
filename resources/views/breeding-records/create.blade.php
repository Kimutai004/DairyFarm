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
                <a href="{{ route('breeding-records.create') }}" class="menu-item active">
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
                                    <i class="fas fa-venus-mars me-2"></i>
                                    Record Breeding
                                </h2>
                                <p class="page-subtitle">Track cattle breeding and reproduction events</p>
                            </div>
                            <a href="{{ route('breeding-records.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Records
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breeding Form -->
            <div class="row">
                <div class="col-12">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle me-2"></i>New Breeding Record</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('breeding-records.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <!-- Cattle Selection -->
                                    <div class="col-md-6 mb-3">
                                        <label for="cattle_id" class="form-label">
                                            <i class="fas fa-cow me-2"></i>Select Female Cattle
                                        </label>
                                        <select class="form-select @error('cattle_id') is-invalid @enderror" 
                                                id="cattle_id" name="cattle_id" required>
                                            <option value="">Select cattle...</option>
                                            @foreach($cattle as $animal)
                                                <option value="{{ $animal->id }}" {{ old('cattle_id') == $animal->id ? 'selected' : '' }}>
                                                    {{ $animal->tag_number }} - {{ $animal->name }} ({{ $animal->breed }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cattle_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Breeding Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="breeding_date" class="form-label">
                                            <i class="fas fa-calendar me-2"></i>Breeding Date
                                        </label>
                                        <input type="date" 
                                               class="form-control @error('breeding_date') is-invalid @enderror" 
                                               id="breeding_date" 
                                               name="breeding_date" 
                                               value="{{ old('breeding_date', date('Y-m-d')) }}" 
                                               max="{{ date('Y-m-d') }}"
                                               required>
                                        @error('breeding_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Breeding Method -->
                                    <div class="col-md-6 mb-3">
                                        <label for="breeding_method" class="form-label">
                                            <i class="fas fa-seedling me-2"></i>Breeding Method
                                        </label>
                                        <select class="form-select @error('breeding_method') is-invalid @enderror" 
                                                id="breeding_method" name="breeding_method" required>
                                            <option value="">Select method...</option>
                                            <option value="AI" {{ old('breeding_method') == 'AI' ? 'selected' : '' }}>Artificial Insemination (AI)</option>
                                            <option value="Natural" {{ old('breeding_method') == 'Natural' ? 'selected' : '' }}>Natural Breeding</option>
                                            <option value="Embryo Transfer" {{ old('breeding_method') == 'Embryo Transfer' ? 'selected' : '' }}>Embryo Transfer</option>
                                        </select>
                                        @error('breeding_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Sire Information -->
                                    <div class="col-md-6 mb-3">
                                        <label for="sire_breed" class="form-label">
                                            <i class="fas fa-male me-2"></i>Sire Breed (Optional)
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('sire_breed') is-invalid @enderror" 
                                               id="sire_breed" 
                                               name="sire_breed" 
                                               value="{{ old('sire_breed') }}" 
                                               placeholder="Enter sire breed or ID">
                                        @error('sire_breed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Expected Calving Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="expected_calving_date" class="form-label">
                                            <i class="fas fa-baby me-2"></i>Expected Calving Date
                                        </label>
                                        <input type="date" 
                                               class="form-control @error('expected_calving_date') is-invalid @enderror" 
                                               id="expected_calving_date" 
                                               name="expected_calving_date" 
                                               value="{{ old('expected_calving_date') }}" 
                                               readonly>
                                        <div class="form-text">Automatically calculated (280 days from breeding)</div>
                                        @error('expected_calving_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Pregnancy Status -->
                                    <div class="col-md-6 mb-3">
                                        <label for="pregnancy_confirmed" class="form-label">
                                            <i class="fas fa-check-circle me-2"></i>Pregnancy Status
                                        </label>
                                        <select class="form-select @error('pregnancy_confirmed') is-invalid @enderror" 
                                                id="pregnancy_confirmed" name="pregnancy_confirmed">
                                            <option value="">Pending Confirmation</option>
                                            <option value="1" {{ old('pregnancy_confirmed') == '1' ? 'selected' : '' }}>Confirmed Pregnant</option>
                                            <option value="0" {{ old('pregnancy_confirmed') == '0' ? 'selected' : '' }}>Not Pregnant</option>
                                        </select>
                                        @error('pregnancy_confirmed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Additional Notes -->
                                <div class="mb-3">
                                    <label for="notes" class="form-label">
                                        <i class="fas fa-sticky-note me-2"></i>Additional Notes (Optional)
                                    </label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" 
                                              name="notes" 
                                              rows="4" 
                                              placeholder="Enter any additional breeding notes, observations, or special instructions...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('breeding-records.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Breeding Record
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information Card -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="info-card">
                        <div class="info-header">
                            <i class="fas fa-info-circle"></i>
                            <h6>Breeding Information</h6>
                        </div>
                        <div class="info-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Gestation Period:</strong><br>
                                    <small>Cattle gestation is approximately 280 days (9 months)</small>
                                </div>
                                <div class="col-md-4">
                                    <strong>Heat Cycle:</strong><br>
                                    <small>Cattle come into heat every 21 days on average</small>
                                </div>
                                <div class="col-md-4">
                                    <strong>Best Breeding Time:</strong><br>
                                    <small>12-24 hours after heat detection for optimal conception</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.sidebar-styles')

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

    // Auto-calculate expected calving date
    const breedingDateInput = document.getElementById('breeding_date');
    const expectedCalvingInput = document.getElementById('expected_calving_date');

    function calculateExpectedCalving() {
        if (breedingDateInput.value) {
            const breedingDate = new Date(breedingDateInput.value);
            const expectedCalving = new Date(breedingDate);
            expectedCalving.setDate(expectedCalving.getDate() + 280); // 280 days gestation
            
            // Format date for input field (YYYY-MM-DD)
            const year = expectedCalving.getFullYear();
            const month = String(expectedCalving.getMonth() + 1).padStart(2, '0');
            const day = String(expectedCalving.getDate()).padStart(2, '0');
            
            expectedCalvingInput.value = `${year}-${month}-${day}`;
        } else {
            expectedCalvingInput.value = '';
        }
    }

    // Calculate on page load if breeding date is set
    calculateExpectedCalving();

    // Recalculate when breeding date changes
    breedingDateInput.addEventListener('change', calculateExpectedCalving);
});
</script>
@endsection
