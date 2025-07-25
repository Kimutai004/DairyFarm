@extends('admin.layout')

@section('title', $employee->name . ' - Employee Details')
@section('page-title', 'Employee Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="fas fa-user me-2"></i>{{ $employee->name }}
    </h4>
    <div>
        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i>Edit Employee
        </a>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to List
        </a>
    </div>
</div>

<div class="row">
    <!-- Employee Information -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>Personal Information
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="avatar-circle bg-primary text-white mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ substr($employee->name, 0, 1) }}
                </div>
                <h5>{{ $employee->name }}</h5>
                <p class="text-muted mb-3">{{ ucfirst($employee->role) }}</p>
                
                <div class="row text-start">
                    <div class="col-12 mb-2">
                        <strong>Email:</strong><br>
                        <span class="text-muted">{{ $employee->email }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Phone:</strong><br>
                        <span class="text-muted">{{ $employee->phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Address:</strong><br>
                        <span class="text-muted">{{ $employee->address ?? 'Not provided' }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <strong>Joined:</strong><br>
                        <span class="text-muted">{{ $employee->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="col-lg-8 mb-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $employee->cattle->count() }}</h4>
                            <p class="mb-0">Total Cattle</p>
                        </div>
                        <i class="fas fa-cow fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="stats-card info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $employee->cattle->where('status', 'active')->count() }}</h4>
                            <p class="mb-0">Active Cattle</p>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="stats-card warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ number_format($employee->milkProductions->sum('total_milk'), 1) }}L</h4>
                            <p class="mb-0">Total Milk</p>
                        </div>
                        <i class="fas fa-glass-whiskey fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-activity me-2"></i>Recent Activities
                </h5>
            </div>
            <div class="card-body">
                @if($employee->milkProductions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                    <th>Cattle</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee->milkProductions->take(10) as $production)
                                <tr>
                                    <td>{{ $production->production_date->format('M d') }}</td>
                                    <td>
                                        <span class="badge bg-success">Milk Production</span>
                                    </td>
                                    <td>{{ $production->cattle->name }}</td>
                                    <td>{{ number_format($production->total_milk, 1) }}L</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No recent activities found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cattle Management -->
@if($employee->cattle->count() > 0)
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-cow me-2"></i>Managed Cattle
        </h5>
        <span class="badge bg-primary">{{ $employee->cattle->count() }} cattle</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tag Number</th>
                        <th>Name</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Latest Milk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employee->cattle as $cattle)
                    <tr>
                        <td>
                            <span class="badge bg-secondary">{{ $cattle->tag_number }}</span>
                        </td>
                        <td>{{ $cattle->name }}</td>
                        <td>{{ $cattle->breed }}</td>
                        <td>{{ $cattle->age }} years</td>
                        <td>
                            <span class="badge bg-{{ $cattle->status === 'active' ? 'success' : 'warning' }}">
                                {{ ucfirst($cattle->status) }}
                            </span>
                        </td>
                        <td>
                            @if($cattle->latestMilkProduction)
                                {{ number_format($cattle->latestMilkProduction->total_milk, 1) }}L
                                <br><small class="text-muted">{{ $cattle->latestMilkProduction->production_date->format('M d') }}</small>
                            @else
                                <span class="text-muted">No records</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .avatar-circle {
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
</style>
@endpush
