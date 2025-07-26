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
                <a href="{{ route('health-records.index') }}" class="menu-item active">
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
                                    <i class="fas fa-heartbeat me-2"></i>
                                    Health Records
                                </h2>
                                <p class="page-subtitle">Manage cattle health and veterinary records</p>
                            </div>
                            <a href="{{ route('health-records.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                New Health Record
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="stat-card primary">
                    <span class="stat-number">{{ $healthRecords->total() }}</span>
                    <span class="stat-label">Total Records</span>
                </div>
                <div class="stat-card warning">
                    <span class="stat-number">{{ \App\Models\HealthRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->where('next_checkup_date', '>=', today())->where('next_checkup_date', '<=', today()->addDays(7))->count() }}</span>
                    <span class="stat-label">Upcoming Checkups</span>
                </div>
                <div class="stat-card success">
                    <span class="stat-number">{{ \App\Models\HealthRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereDate('checkup_date', today())->count() }}</span>
                    <span class="stat-label">Today's Records</span>
                </div>
                <div class="stat-card info">
                    <span class="stat-number">${{ number_format(\App\Models\HealthRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereMonth('checkup_date', now()->month)->sum('cost'), 0) }}</span>
                    <span class="stat-label">Monthly Cost</span>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="filter-controls">
                <form method="GET" action="{{ route('health-records.index') }}">
                    <div class="filter-grid">
                        <div>
                            <label for="cattle_filter" class="form-label">Filter by Cattle</label>
                            <select name="cattle_id" id="cattle_filter" class="form-select">
                                <option value="">All Cattle</option>
                                @foreach(\App\Models\Cattle::where('user_id', auth()->id())->get() as $cattle)
                                    <option value="{{ $cattle->id }}" {{ request('cattle_id') == $cattle->id ? 'selected' : '' }}>
                                        {{ $cattle->tag_number }} - {{ $cattle->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="checkup_type_filter" class="form-label">Filter by Type</label>
                            <select name="checkup_type" id="checkup_type_filter" class="form-select">
                                <option value="">All Types</option>
                                <option value="Routine Checkup" {{ request('checkup_type') == 'Routine Checkup' ? 'selected' : '' }}>Routine Checkup</option>
                                <option value="Vaccination" {{ request('checkup_type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                <option value="Treatment" {{ request('checkup_type') == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                                <option value="Emergency" {{ request('checkup_type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div>
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('health-records.index') }}" class="btn btn-light">Clear</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Health Records Table -->
            <div class="row">
                <div class="col-12">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-list me-2"></i>Health Records</h5>
                        </div>
                        <div class="card-body">
                            @if($healthRecords->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Cattle</th>
                                                <th>Type</th>
                                                <th>Veterinarian</th>
                                                <th>Diagnosis</th>
                                                <th>Next Checkup</th>
                                                <th>Cost</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($healthRecords as $record)
                                            <tr>
                                                <td>{{ $record->checkup_date->format('M j, Y') }}</td>
                                                <td>
                                                    <strong>{{ $record->cattle->tag_number }}</strong><br>
                                                    <small class="text-muted">{{ $record->cattle->name }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $record->checkup_type }}</span>
                                                </td>
                                                <td>{{ $record->veterinarian ?? 'N/A' }}</td>
                                                <td>{{ Str::limit($record->diagnosis ?? 'N/A', 50) }}</td>
                                                <td>
                                                    @if($record->next_checkup_date)
                                                        {{ $record->next_checkup_date->format('M j, Y') }}
                                                        @if($record->next_checkup_date->isPast())
                                                            <span class="badge bg-danger ms-1">Overdue</span>
                                                        @elseif($record->next_checkup_date->diffInDays(now()) <= 7)
                                                            <span class="badge bg-warning ms-1">Due Soon</span>
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>${{ number_format($record->cost ?? 0, 2) }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('health-records.show', $record->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('health-records.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('health-records.destroy', $record->id) }}" method="POST" style="display: inline;">
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
                                    {{ $healthRecords->links() }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-heartbeat"></i>
                                    <h5>No Health Records Found</h5>
                                    <p class="text-muted">Start by recording your first health checkup.</p>
                                    <a href="{{ route('health-records.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Add First Health Record
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
@endsection
