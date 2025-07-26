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
                                    <i class="fas fa-wheat-awn me-2"></i>
                                    Feed Records
                                </h2>
                                <p class="page-subtitle">Track cattle feeding and nutrition</p>
                            </div>
                            <a href="{{ route('feed-records.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                New Feed Record
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="stats-overview">
                <div class="stat-card primary">
                    <span class="stat-number">{{ $feedRecords->total() }}</span>
                    <span class="stat-label">Total Records</span>
                </div>
                <div class="stat-card success">
                    <span class="stat-number">{{ \App\Models\FeedRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereDate('feeding_date', today())->count() }}</span>
                    <span class="stat-label">Today's Feedings</span>
                </div>
                <div class="stat-card warning">
                    <span class="stat-number">{{ number_format(\App\Models\FeedRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereDate('feeding_date', today())->sum('quantity'), 1) }}</span>
                    <span class="stat-label">Today's Quantity</span>
                </div>
                <div class="stat-card info">
                    <span class="stat-number">${{ number_format(\App\Models\FeedRecord::whereHas('cattle', function($q) { $q->where('user_id', auth()->id()); })->whereMonth('feeding_date', now()->month)->sum('total_cost'), 0) }}</span>
                    <span class="stat-label">Monthly Cost</span>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="filter-controls">
                <form method="GET" action="{{ route('feed-records.index') }}">
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
                            <label for="feed_type_filter" class="form-label">Filter by Feed Type</label>
                            <select name="feed_type" id="feed_type_filter" class="form-select">
                                <option value="">All Types</option>
                                <option value="Hay" {{ request('feed_type') == 'Hay' ? 'selected' : '' }}>Hay</option>
                                <option value="Silage" {{ request('feed_type') == 'Silage' ? 'selected' : '' }}>Silage</option>
                                <option value="Grain" {{ request('feed_type') == 'Grain' ? 'selected' : '' }}>Grain</option>
                                <option value="Pasture" {{ request('feed_type') == 'Pasture' ? 'selected' : '' }}>Pasture</option>
                                <option value="Supplements" {{ request('feed_type') == 'Supplements' ? 'selected' : '' }}>Supplements</option>
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="form-label">From Date</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div>
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('feed-records.index') }}" class="btn btn-light">Clear</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Feed Records Table -->
            <div class="row">
                <div class="col-12">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-list me-2"></i>Feed Records</h5>
                        </div>
                        <div class="card-body">
                            @if($feedRecords->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Cattle</th>
                                                <th>Feed Type</th>
                                                <th>Quantity</th>
                                                <th>Unit Cost</th>
                                                <th>Total Cost</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($feedRecords as $record)
                                            <tr>
                                                <td>{{ $record->feeding_date->format('M j, Y') }}</td>
                                                <td>
                                                    <strong>{{ $record->cattle->tag_number }}</strong><br>
                                                    <small class="text-muted">{{ $record->cattle->name }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">{{ $record->feed_type }}</span>
                                                </td>
                                                <td>{{ number_format($record->quantity, 1) }} {{ $record->unit }}</td>
                                                <td>${{ number_format($record->cost_per_unit ?? 0, 2) }}</td>
                                                <td>${{ number_format($record->total_cost ?? 0, 2) }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('feed-records.show', $record->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('feed-records.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('feed-records.destroy', $record->id) }}" method="POST" style="display: inline;">
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
                                    {{ $feedRecords->links() }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-wheat-awn"></i>
                                    <h5>No Feed Records Found</h5>
                                    <p class="text-muted">Start by recording your first feeding session.</p>
                                    <a href="{{ route('feed-records.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Add First Feed Record
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
