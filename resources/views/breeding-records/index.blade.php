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
                                    <i class="fas fa-heart me-2"></i>
                                    Breeding Records
                                </h2>
                                <p class="page-subtitle">Track cattle breeding and reproduction</p>
                            </div>
                            <a href="{{ route('breeding-records.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                New Breeding Record
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="stat-card primary">
                    <span class="stat-number">{{ $breedingRecords->total() }}</span>
                    <span class="stat-label">Total Records</span>
                </div>
                <div class="stat-card success">
                    <span class="stat-number">{{ \App\Models\BreedingRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->where('pregnancy_confirmed', true)->count() }}</span>
                    <span class="stat-label">Confirmed Pregnancies</span>
                </div>
                <div class="stat-card warning">
                    <span class="stat-number">{{ \App\Models\BreedingRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->where('expected_calving_date', '>=', today())->where('expected_calving_date', '<=', today()->addDays(30))->count() }}</span>
                    <span class="stat-label">Due This Month</span>
                </div>
                <div class="stat-card info">
                    <span class="stat-number">{{ \App\Models\Cattle::where('user_id', auth()->id())->where('gender', 'female')->where('status', 'active')->count() }}</span>
                    <span class="stat-label">Breeding Females</span>
                </div>
            </div>

            <!-- Breeding Records Table -->
            <div class="row">
                <div class="col-12">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-list me-2"></i>Breeding Records</h5>
                        </div>
                        <div class="card-body">
                            @if($breedingRecords->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Breeding Date</th>
                                                <th>Cattle</th>
                                                <th>Method</th>
                                                <th>Sire Breed</th>
                                                <th>Expected Calving</th>
                                                <th>Pregnancy Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($breedingRecords as $record)
                                            <tr>
                                                <td>{{ $record->breeding_date->format('M j, Y') }}</td>
                                                <td>
                                                    <strong>{{ $record->cattle->tag_number }}</strong><br>
                                                    <small class="text-muted">{{ $record->cattle->name }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $record->breeding_method }}</span>
                                                </td>
                                                <td>{{ $record->sire_breed ?? 'N/A' }}</td>
                                                <td>
                                                    @if($record->expected_calving_date)
                                                        {{ $record->expected_calving_date->format('M j, Y') }}
                                                        @if($record->expected_calving_date->isPast() && !$record->actual_calving_date)
                                                            <span class="badge bg-danger ms-1">Overdue</span>
                                                        @elseif($record->expected_calving_date->diffInDays(now()) <= 7)
                                                            <span class="badge bg-warning ms-1">Due Soon</span>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($record->pregnancy_confirmed === true)
                                                        <span class="badge bg-success">Confirmed</span>
                                                    @elseif($record->pregnancy_confirmed === false)
                                                        <span class="badge bg-danger">Not Pregnant</span>
                                                    @else
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('breeding-records.show', $record->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('breeding-records.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('breeding-records.destroy', $record->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
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
                                <div class="d-flex justify-content-center">
                                    {{ $breedingRecords->links() }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-heart"></i>
                                    <h5>No Breeding Records Found</h5>
                                    <p class="text-muted">Start by recording your first breeding session.</p>
                                    <a href="{{ route('breeding-records.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Add First Breeding Record
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

<style>
/* Hide navbar for this page */
.navbar {
    display: none !important;
}
</style>
@endsection
