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
                                    <i class="fas fa-cow me-2"></i>
                                    My Cattle
                                </h2>
                                <p class="page-subtitle">Manage your livestock and track their information</p>
                            </div>
                            <a href="{{ route('cattle.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>
                                Add New Cattle
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-cow"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $cattle->total() }}</h3>
                            <p>Total Cattle</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $cattle->where('status', 'active')->count() }}</h3>
                            <p>Active</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-venus"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $cattle->where('gender', 'female')->count() }}</h3>
                            <p>Female</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card info">
                        <div class="stat-icon">
                            <i class="fas fa-mars"></i>
                        </div>
                        <div class="stat-content">
                            <h3>{{ $cattle->where('gender', 'male')->count() }}</h3>
                            <p>Male</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cattle Grid -->
            <div class="row">
                <div class="col-12">
                    <div class="farmer-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5><i class="fas fa-list me-2"></i>Cattle List</h5>
                                <div class="card-tools">
                                    <form method="GET" class="d-flex">
                                        <select name="status" class="form-select me-2">
                                            <option value="">All Status</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                            <option value="deceased" {{ request('status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                                            <option value="dry" {{ request('status') == 'dry' ? 'selected' : '' }}>Dry</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-primary">
                                            <i class="fas fa-filter"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($cattle->count() > 0)
                            <div class="cattle-grid">
                                @foreach($cattle as $cow)
                                <div class="cattle-item">
                                    <div class="cattle-header">
                                        <div class="cattle-avatar">
                                            <i class="fas fa-cow"></i>
                                        </div>
                                        <div class="cattle-info">
                                            <h5>{{ $cow->tag_number }}</h5>
                                            <p class="cattle-name">{{ $cow->name }}</p>
                                        </div>
                                        <div class="cattle-actions">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('cattle.show', $cow->id) }}">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('cattle.edit', $cow->id) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form method="POST" action="{{ route('cattle.destroy', $cow->id) }}" 
                                                              onsubmit="return confirm('Are you sure you want to remove this cattle?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i>Remove
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="cattle-details">
                                        <div class="detail-row">
                                            <span class="detail-label">Breed:</span>
                                            <span class="detail-value">{{ ucfirst($cow->breed) }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Gender:</span>
                                            <span class="detail-value">
                                                <i class="fas fa-{{ $cow->gender == 'female' ? 'venus' : 'mars' }} me-1"></i>
                                                {{ ucfirst($cow->gender) }}
                                            </span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Age:</span>
                                            <span class="detail-value">{{ \Carbon\Carbon::parse($cow->date_of_birth)->age }} years</span>
                                        </div>
                                        @if($cow->weight)
                                        <div class="detail-row">
                                            <span class="detail-label">Weight:</span>
                                            <span class="detail-value">{{ number_format($cow->weight) }} kg</span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="cattle-footer">
                                        <span class="status-badge {{ $cow->status }}">{{ ucfirst($cow->status) }}</span>
                                        <small class="text-muted">Added {{ $cow->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $cattle->withQueryString()->links() }}
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-cow fa-3x text-muted mb-3"></i>
                                <h5>No cattle registered yet</h5>
                                <p class="text-muted">Start by adding your first cattle to the farm.</p>
                                <a href="{{ route('cattle.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    Add First Cattle
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

<style>
.cattle-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.cattle-item {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    border: 1px solid #e9ecef;
}

.cattle-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.cattle-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.cattle-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.cattle-info {
    flex: 1;
}

.cattle-info h5 {
    margin: 0;
    font-weight: 700;
    color: #495057;
}

.cattle-name {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.cattle-details {
    margin-bottom: 1rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.25rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 500;
    color: #6c757d;
    font-size: 0.875rem;
}

.detail-value {
    color: #495057;
    font-weight: 600;
    font-size: 0.875rem;
}

.cattle-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid #f8f9fa;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.sold {
    background: #fff3cd;
    color: #856404;
}

.status-badge.deceased {
    background: #f8d7da;
    color: #721c24;
}

.status-badge.dry {
    background: #d1ecf1;
    color: #0c5460;
}

@media (max-width: 768px) {
    .cattle-grid {
        grid-template-columns: 1fr;
    }
    
    .card-tools {
        margin-top: 1rem;
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

@include('layouts.sidebar-styles')

<style>
/* Hide default Laravel navbar for dashboard pages */
.navbar {
    display: none !important;
}

/* Adjust main content to account for no navbar */
main.py-4 {
    padding: 0 !important;
}
</style>
@endsection
