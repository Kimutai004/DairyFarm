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
                                    <i class="fas fa-eye me-2"></i>
                                    Breeding Record Details
                                </h2>
                                <p class="page-subtitle">View detailed breeding information</p>
                            </div>
                            <div>
                                <a href="{{ route('breeding-records.edit', $breedingRecord->id) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Record
                                </a>
                                <a href="{{ route('breeding-records.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Records
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Breeding Record Details -->
            <div class="row">
                <div class="col-md-8">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle me-2"></i>Breeding Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Cattle</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-cow me-2"></i>
                                        {{ $breedingRecord->cattle->tag_number }} - {{ $breedingRecord->cattle->name }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Breed</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-dna me-2"></i>
                                        {{ $breedingRecord->cattle->breed }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Breeding Date</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-calendar me-2"></i>
                                        {{ $breedingRecord->breeding_date->format('F j, Y') }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Breeding Method</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-seedling me-2"></i>
                                        <span class="badge bg-info">{{ $breedingRecord->breeding_method }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($breedingRecord->sire_breed)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Sire Breed</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-male me-2"></i>
                                        {{ $breedingRecord->sire_breed }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Expected Calving Date</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-baby me-2"></i>
                                        @if($breedingRecord->expected_calving_date)
                                            {{ $breedingRecord->expected_calving_date->format('F j, Y') }}
                                            @if($breedingRecord->expected_calving_date->isPast() && !$breedingRecord->actual_calving_date)
                                                <span class="badge bg-danger ms-2">Overdue</span>
                                            @elseif($breedingRecord->expected_calving_date->diffInDays(now()) <= 7)
                                                <span class="badge bg-warning ms-2">Due Soon</span>
                                            @endif
                                        @else
                                            Not calculated
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Pregnancy Status</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-check-circle me-2"></i>
                                        @if($breedingRecord->pregnancy_confirmed === true)
                                            <span class="badge bg-success">Confirmed Pregnant</span>
                                        @elseif($breedingRecord->pregnancy_confirmed === false)
                                            <span class="badge bg-danger">Not Pregnant</span>
                                        @else
                                            <span class="badge bg-secondary">Pending Confirmation</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($breedingRecord->actual_calving_date)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Actual Calving Date</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        {{ $breedingRecord->actual_calving_date->format('F j, Y') }}
                                        <span class="badge bg-success ms-2">Calved</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($breedingRecord->notes)
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label"><strong>Notes</strong></label>
                                    <div class="info-display">
                                        <i class="fas fa-sticky-note me-2"></i>
                                        {{ $breedingRecord->notes }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Timeline -->
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-timeline me-2"></i>Breeding Timeline</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item completed">
                                    <div class="timeline-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Breeding</h6>
                                        <p>{{ $breedingRecord->breeding_date->format('M j, Y') }}</p>
                                        <small class="text-muted">{{ $breedingRecord->breeding_method }}</small>
                                    </div>
                                </div>

                                @if($breedingRecord->pregnancy_confirmed === true)
                                <div class="timeline-item completed">
                                    <div class="timeline-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Pregnancy Confirmed</h6>
                                        <small class="text-success">Pregnancy confirmed</small>
                                    </div>
                                </div>
                                @elseif($breedingRecord->pregnancy_confirmed === false)
                                <div class="timeline-item failed">
                                    <div class="timeline-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Not Pregnant</h6>
                                        <small class="text-danger">Pregnancy not confirmed</small>
                                    </div>
                                </div>
                                @endif

                                @if($breedingRecord->expected_calving_date)
                                <div class="timeline-item {{ $breedingRecord->actual_calving_date ? 'completed' : ($breedingRecord->expected_calving_date->isPast() ? 'overdue' : 'pending') }}">
                                    <div class="timeline-icon">
                                        <i class="fas fa-baby"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Expected Calving</h6>
                                        <p>{{ $breedingRecord->expected_calving_date->format('M j, Y') }}</p>
                                        @if($breedingRecord->actual_calving_date)
                                            <small class="text-success">Calved on {{ $breedingRecord->actual_calving_date->format('M j, Y') }}</small>
                                        @elseif($breedingRecord->expected_calving_date->isPast())
                                            <small class="text-danger">Overdue</small>
                                        @else
                                            <small class="text-muted">{{ $breedingRecord->expected_calving_date->diffForHumans() }}</small>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="farmer-card mt-3">
                        <div class="card-header">
                            <h5><i class="fas fa-tools me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('breeding-records.edit', $breedingRecord->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Record
                                </a>
                                @if($breedingRecord->pregnancy_confirmed === true && !$breedingRecord->actual_calving_date)
                                <button class="btn btn-success" onclick="updateCalvingDate()">
                                    <i class="fas fa-baby me-2"></i>
                                    Record Calving
                                </button>
                                @endif
                                <form action="{{ route('breeding-records.destroy', $breedingRecord->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this breeding record?')">
                                        <i class="fas fa-trash me-2"></i>
                                        Delete Record
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

@include('layouts.sidebar-styles')

<style>
.info-display {
    padding: 0.75rem 1rem;
    background-color: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-icon {
    position: absolute;
    left: -2rem;
    top: 0;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    color: white;
}

.timeline-item.completed .timeline-icon {
    background: var(--bs-success);
}

.timeline-item.pending .timeline-icon {
    background: var(--bs-warning);
}

.timeline-item.overdue .timeline-icon {
    background: var(--bs-danger);
}

.timeline-item.failed .timeline-icon {
    background: var(--bs-danger);
}

.timeline-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.timeline-content p {
    margin-bottom: 0.25rem;
    color: var(--bs-dark);
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

function updateCalvingDate() {
    const today = new Date().toISOString().split('T')[0];
    const date = prompt('Enter the actual calving date (YYYY-MM-DD):', today);
    
    if (date) {
        // You would typically make an AJAX request here to update the record
        alert('Feature coming soon! For now, please use the edit form to update the calving date.');
        window.location.href = '{{ route("breeding-records.edit", $breedingRecord->id) }}';
    }
}
</script>

<style>
/* Hide navbar for this page */
.navbar {
    display: none !important;
}
</style>
@endsection
