@extends('admin.layout')

@section('page-title', 'Cattle Management')

@section('content')
<div class="cattle-management">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-0">🐄 Cattle Management</h4>
                <p class="text-muted">Manage your farm's cattle inventory</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.cattle.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Cattle
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-cow"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $cattle->total() }}</h3>
                    <p>Total Cattle</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $cattle->where('status', 'active')->count() }}</h3>
                    <p>Active Cattle</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-venus"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $cattle->where('gender', 'female')->count() }}</h3>
                    <p>Female</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-mars"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $cattle->where('gender', 'male')->count() }}</h3>
                    <p>Male</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cattle Table -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="mb-0">Cattle List</h5>
            <div class="table-actions">
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Search cattle..." id="cattleSearch">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table cattle-table">
                <thead>
                    <tr>
                        <th>Tag Number</th>
                        <th>Breed</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Assigned To</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cattle as $animal)
                    <tr>
                        <td>
                            <div class="cattle-tag">
                                <strong>{{ $animal->tag_number }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="breed-badge">{{ ucfirst($animal->breed) }}</span>
                        </td>
                        <td>
                            <i class="fas fa-{{ $animal->gender == 'female' ? 'venus' : 'mars' }} me-1"></i>
                            {{ ucfirst($animal->gender) }}
                        </td>
                        <td>
                            @php
                                $age = \Carbon\Carbon::parse($animal->date_of_birth)->age;
                            @endphp
                            {{ $age }} {{ $age == 1 ? 'year' : 'years' }}
                        </td>
                        <td>
                            @if($animal->user)
                                <div class="assigned-user">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $animal->user->name }}
                                </div>
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $animal->status }}">
                                {{ ucfirst($animal->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.cattle.show', $animal->id) }}" 
                                   class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.cattle.edit', $animal->id) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.cattle.destroy', $animal->id) }}" 
                                      method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-cow fa-3x text-muted mb-3"></i>
                                <h5>No cattle registered yet</h5>
                                <p class="text-muted">Start by adding your first cattle to the system.</p>
                                <a href="{{ route('admin.cattle.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Cattle
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cattle->hasPages())
        <div class="table-footer">
            {{ $cattle->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.cattle-management {
    padding: 0;
}

.page-header {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.page-title {
    color: #333;
    font-weight: 700;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #333;
}

.stat-content p {
    color: #6c757d;
    margin: 0;
    font-weight: 500;
}

.table-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.table-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
}

.table-header h5 {
    color: #333;
    font-weight: 700;
}

.search-box {
    position: relative;
    width: 300px;
}

.search-box input {
    padding-right: 40px;
    border-radius: 25px;
    border: 1px solid #e0e0e0;
}

.search-box i {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.cattle-table {
    margin: 0;
}

.cattle-table th {
    border: none;
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
    padding: 1rem 1.5rem;
}

.cattle-table td {
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.cattle-tag strong {
    font-family: 'Courier New', monospace;
    background: #e3f2fd;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    color: #1976d2;
}

.breed-badge {
    background: #f0f4f8;
    color: #5a6c7d;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 500;
}

.assigned-user {
    color: #28a745;
    font-weight: 500;
}

.status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.status-sold {
    background: #d1ecf1;
    color: #0c5460;
}

.status-deceased {
    background: #f1f3f4;
    color: #5f6368;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-buttons .btn {
    border-radius: 8px;
    transition: all 0.2s ease;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.table-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
    
    .search-box {
        width: 100%;
        margin-top: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('cattleSearch');
    const tableRows = document.querySelectorAll('.cattle-table tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                if (row.querySelector('.empty-state')) return;
                
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this cattle? This action cannot be undone.')) {
                this.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
