@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="page-title">
                            <i class="fas fa-glass-whiskey me-2"></i>
                            Milk Production Records
                        </h2>
                        <p class="page-subtitle">Track and manage daily milk production</p>
                    </div>
                    <a href="{{ route('milk-production.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        Record Production
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
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->where('production_date', today())->sum('total_milk'), 1) }}L</h3>
                    <p>Today's Production</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->where('production_date', '>=', now()->startOfWeek())->sum('total_milk'), 1) }}L</h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->where('production_date', '>=', now()->startOfMonth())->sum('total_milk'), 1) }}L</h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($milkProductions->avg('total_milk'), 1) }}L</h3>
                    <p>Average Daily</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Production Records -->
    <div class="row">
        <div class="col-12">
            <div class="farmer-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-list me-2"></i>Production Records</h5>
                        <div class="card-tools">
                            <form method="GET" class="d-flex">
                                <input type="date" name="date" class="form-control me-2" 
                                       value="{{ request('date') }}" placeholder="Filter by date">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($milkProductions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cattle</th>
                                    <th>Morning (L)</th>
                                    <th>Evening (L)</th>
                                    <th>Total (L)</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($milkProductions as $production)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $production->production_date->format('M d, Y') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $production->production_date->format('l') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="cattle-avatar me-2">
                                                <i class="fas fa-cow"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold">{{ $production->cattle->tag_number }}</span>
                                                <br>
                                                <small class="text-muted">{{ ucfirst($production->cattle->breed) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($production->morning_milk, 1) }}L</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ number_format($production->evening_milk, 1) }}L</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success fs-6">{{ number_format($production->total_milk, 1) }}L</span>
                                    </td>
                                    <td>
                                        {{ Str::limit($production->notes, 30) }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('milk-production.show', $production->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('milk-production.edit', $production->id) }}" 
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('milk-production.destroy', $production->id) }}" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $milkProductions->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-glass-whiskey fa-3x text-muted mb-3"></i>
                        <h5>No milk production records yet</h5>
                        <p class="text-muted">Start by recording your first milk production.</p>
                        <a href="{{ route('milk-production.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Record First Production
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 0;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    opacity: 0.9;
    margin: 0;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    border-left: 4px solid;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card.primary { border-left-color: #667eea; }
.stat-card.success { border-left-color: #28a745; }
.stat-card.warning { border-left-color: #ffc107; }
.stat-card.info { border-left-color: #17a2b8; }

.stat-card .stat-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #6c757d;
}

.stat-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #333;
}

.stat-card p {
    color: #6c757d;
    margin: 0;
}

.farmer-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
}

.farmer-card .card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 15px 15px 0 0;
    padding: 1rem 1.5rem;
}

.farmer-card .card-body {
    padding: 1.5rem;
}

.cattle-avatar {
    width: 40px;
    height: 40px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    border-radius: 6px !important;
    margin-right: 2px;
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
    
    .card-tools {
        margin-top: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endsection
