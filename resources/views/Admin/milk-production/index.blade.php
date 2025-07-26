@extends('admin.layout')

@section('page-title', 'Milk Production')

@section('content')
<div class="milk-production-management">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-0">🥛 Milk Production Management</h4>
                <p class="text-muted">Track and manage daily milk production</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.milk-production.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Record Production
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($todayTotal, 1) }}L</h3>
                    <p>Today's Production</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($weekTotal, 1) }}L</h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($monthTotal, 1) }}L</h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $productions->total() }}</h3>
                    <p>Total Records</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Production Table -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="mb-0">Production Records</h5>
            <div class="table-actions">
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Search records..." id="productionSearch">
                    <i class="fas fa-search"></i>
                </div>
                <div class="filter-dropdown ms-2">
                    <select class="form-select" id="dateFilter">
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table production-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Cattle</th>
                        <th>Farmer</th>
                        <th>Morning</th>
                        <th>Evening</th>
                        <th>Total</th>
                        <th>Quality</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productions as $production)
                    <tr>
                        <td>
                            <div class="production-date">
                                <strong>{{ $production->production_date->format('M d, Y') }}</strong>
                                <small class="d-block text-muted">{{ $production->production_date->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="cattle-info">
                                <span class="cattle-tag">{{ $production->cattle->tag_number }}</span>
                                <small class="d-block text-muted">{{ ucfirst($production->cattle->breed) }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="farmer-info">
                                <i class="fas fa-user me-1"></i>
                                {{ $production->user->name }}
                            </div>
                        </td>
                        <td>
                            <span class="milk-amount morning">{{ number_format($production->morning_milk, 1) }}L</span>
                        </td>
                        <td>
                            <span class="milk-amount evening">{{ number_format($production->evening_milk, 1) }}L</span>
                        </td>
                        <td>
                            <span class="milk-total">{{ number_format($production->total_milk, 1) }}L</span>
                        </td>
                        <td>
                            <span class="quality-grade quality-{{ strtolower($production->quality_grade) }}">
                                Grade {{ $production->quality_grade }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.milk-production.show', $production->id) }}" 
                                   class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.milk-production.edit', $production->id) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.milk-production.destroy', $production->id) }}" 
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
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-glass-whiskey fa-3x text-muted mb-3"></i>
                                <h5>No production records yet</h5>
                                <p class="text-muted">Start by recording your first milk production.</p>
                                <a href="{{ route('admin.milk-production.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Record Production
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($productions->hasPages())
        <div class="table-footer">
            {{ $productions->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.milk-production-management {
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

.table-actions {
    display: flex;
    align-items: center;
}

.search-box {
    position: relative;
    width: 250px;
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

.filter-dropdown select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
}

.production-table {
    margin: 0;
}

.production-table th {
    border: none;
    background: #f8f9fa;
    font-weight: 600;
    color: #333;
    padding: 1rem 1.5rem;
}

.production-table td {
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.production-date strong {
    color: #333;
}

.cattle-tag {
    font-family: 'Courier New', monospace;
    background: #e3f2fd;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    color: #1976d2;
    font-weight: 600;
}

.farmer-info {
    color: #28a745;
    font-weight: 500;
}

.milk-amount {
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

.milk-amount.morning {
    background: #fff3cd;
    color: #856404;
}

.milk-amount.evening {
    background: #d1ecf1;
    color: #0c5460;
}

.milk-total {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    background: #d4edda;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
}

.quality-grade {
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.quality-a {
    background: #d4edda;
    color: #155724;
}

.quality-b {
    background: #fff3cd;
    color: #856404;
}

.quality-c {
    background: #f8d7da;
    color: #721c24;
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
    
    .table-actions {
        flex-direction: column;
        gap: 1rem;
        width: 100%;
    }
    
    .search-box {
        width: 100%;
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
    const searchInput = document.getElementById('productionSearch');
    const tableRows = document.querySelectorAll('.production-table tbody tr');

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

    // Date filter functionality
    const dateFilter = document.getElementById('dateFilter');
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            const filterValue = this.value;
            const today = new Date();
            
            tableRows.forEach(row => {
                if (row.querySelector('.empty-state')) return;
                
                const dateCell = row.querySelector('.production-date strong');
                if (!dateCell) return;
                
                const rowDate = new Date(dateCell.textContent);
                let showRow = true;
                
                switch(filterValue) {
                    case 'today':
                        showRow = rowDate.toDateString() === today.toDateString();
                        break;
                    case 'week':
                        const weekStart = new Date(today.setDate(today.getDate() - today.getDay()));
                        const weekEnd = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                        showRow = rowDate >= weekStart && rowDate <= weekEnd;
                        break;
                    case 'month':
                        showRow = rowDate.getMonth() === today.getMonth() && 
                                 rowDate.getFullYear() === today.getFullYear();
                        break;
                    default:
                        showRow = true;
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        });
    }

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this production record? This action cannot be undone.')) {
                this.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
