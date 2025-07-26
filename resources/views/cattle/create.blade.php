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
                <a href="{{ route('cattle.create') }}" class="menu-item active">
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
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="page-title">
                                    <i class="fas fa-plus me-2"></i>
                                    Add New Cattle
                                </h2>
                                <p class="page-subtitle">Register a new cattle to your farm</p>
                            </div>
                            <a href="{{ route('cattle.index') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Cattle List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-cow me-2"></i>Cattle Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('cattle.store') }}">
                                @csrf

                                <div class="row g-3">
                                    <!-- Tag Number -->
                                    <div class="col-md-6">
                                        <label for="tag_number" class="form-label">Tag Number *</label>
                                        <input id="tag_number" type="text" class="form-control @error('tag_number') is-invalid @enderror" 
                                               name="tag_number" value="{{ old('tag_number') }}" required
                                               placeholder="e.g., COW001">
                                        @error('tag_number')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        <div class="form-text">Unique identifier for this cattle</div>
                                    </div>

                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Cattle Name *</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name') }}" required
                                               placeholder="e.g., Bella">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Breed -->
                                    <div class="col-md-6">
                                        <label for="breed" class="form-label">Breed *</label>
                                        <select id="breed" class="form-select @error('breed') is-invalid @enderror" name="breed" required>
                                            <option value="">Select breed...</option>
                                            <option value="Holstein" {{ old('breed') == 'Holstein' ? 'selected' : '' }}>Holstein</option>
                                            <option value="Jersey" {{ old('breed') == 'Jersey' ? 'selected' : '' }}>Jersey</option>
                                            <option value="Guernsey" {{ old('breed') == 'Guernsey' ? 'selected' : '' }}>Guernsey</option>
                                            <option value="Ayrshire" {{ old('breed') == 'Ayrshire' ? 'selected' : '' }}>Ayrshire</option>
                                            <option value="Brown Swiss" {{ old('breed') == 'Brown Swiss' ? 'selected' : '' }}>Brown Swiss</option>
                                            <option value="Shorthorn" {{ old('breed') == 'Shorthorn' ? 'selected' : '' }}>Shorthorn</option>
                                            <option value="Other" {{ old('breed') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('breed')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender *</label>
                                        <select id="gender" class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                            <option value="">Select gender...</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                <i class="fas fa-venus"></i> Female
                                            </option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                <i class="fas fa-mars"></i> Male
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-md-6">
                                        <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                        <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                               name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                               max="{{ date('Y-m-d') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Weight -->
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Current Weight (kg)</label>
                                        <div class="input-group">
                                            <input id="weight" type="number" step="0.1" min="0" 
                                                   class="form-control @error('weight') is-invalid @enderror" 
                                                   name="weight" value="{{ old('weight') }}"
                                                   placeholder="0.0">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                        @error('weight')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Color -->
                                    <div class="col-md-6">
                                        <label for="color" class="form-label">Color/Markings</label>
                                        <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" 
                                               name="color" value="{{ old('color') }}"
                                               placeholder="e.g., Black and white, Brown">
                                        @error('color')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Age Display -->
                                    <div class="col-md-6">
                                        <label class="form-label">Calculated Age</label>
                                        <div class="age-display">
                                            <span id="calculated_age">-</span>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Additional Notes</label>
                                        <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                  name="notes" rows="4" 
                                                  placeholder="Any additional information about this cattle...">{{ old('notes') }}</textarea>
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
                                        Register Cattle
                                    </button>
                                    <a href="{{ route('cattle.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times me-2"></i>
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar with Tips -->
                <div class="col-lg-4">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-lightbulb me-2"></i>Registration Tips</h5>
                        </div>
                        <div class="card-body">
                            <div class="tips-list">
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Use a unique tag number for easy identification
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Keep accurate birth date records for proper age tracking
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Record weight for health monitoring
                                </div>
                                <div class="tip-item">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Include distinctive markings for identification
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Stats -->
                    <div class="farmer-card mt-3">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-bar me-2"></i>Current Farm Stats</h5>
                        </div>
                        <div class="card-body">
                            <div class="stats-list">
                                <div class="stat-item">
                                    <div class="stat-label">Total Cattle</div>
                                    <div class="stat-value">{{ \App\Models\Cattle::where('user_id', auth()->id())->count() }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">Active Cattle</div>
                                    <div class="stat-value">{{ \App\Models\Cattle::where('user_id', auth()->id())->where('status', 'active')->count() }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">Female Cattle</div>
                                    <div class="stat-value">{{ \App\Models\Cattle::where('user_id', auth()->id())->where('gender', 'female')->count() }}</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-label">Male Cattle</div>
                                    <div class="stat-value">{{ \App\Models\Cattle::where('user_id', auth()->id())->where('gender', 'male')->count() }}</div>
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

<style>
.age-display {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 10px;
    font-weight: 600;
    color: #495057;
    text-align: center;
    border: 1px solid #e9ecef;
}

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

    // Calculate age from date of birth
    const dobInput = document.getElementById('date_of_birth');
    const ageDisplay = document.getElementById('calculated_age');

    function calculateAge() {
        if (dobInput.value) {
            const birthDate = new Date(dobInput.value);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age === 0) {
                // Calculate months for animals less than 1 year
                const months = (today.getFullYear() - birthDate.getFullYear()) * 12 + (today.getMonth() - birthDate.getMonth());
                ageDisplay.textContent = months + ' months';
            } else {
                ageDisplay.textContent = age + ' years';
            }
        } else {
            ageDisplay.textContent = '-';
        }
    }

    dobInput.addEventListener('change', calculateAge);
    
    // Calculate age on page load if value exists
    if (dobInput.value) {
        calculateAge();
    }
});
</script>
@endsection
