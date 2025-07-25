@extends('admin.layout')

@section('title', 'Admin Dashboard - Dairy Farm Management')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">{{ $totalCattle }}</h4>
                    <p class="mb-0">Total Cattle</p>
                </div>
                <i class="fas fa-cow fa-2x opacity-75"></i>
            </div>
            <div class="mt-2">
                <small><i class="fas fa-check-circle me-1"></i>{{ $activeCattle }} Active</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">{{ $totalFarmers }}</h4>
                    <p class="mb-0">Total Farmers</p>
                </div>
                <i class="fas fa-users fa-2x opacity-75"></i>
            </div>
            <div class="mt-2">
                <small><i class="fas fa-user-check me-1"></i>Active Users</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">{{ number_format($todayMilk, 1) }}L</h4>
                    <p class="mb-0">Today's Milk</p>
                </div>
                <i class="fas fa-glass-whiskey fa-2x opacity-75"></i>
            </div>
            <div class="mt-2">
                <small><i class="fas fa-calendar-day me-1"></i>{{ date('M d, Y') }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">${{ number_format($monthlySales, 2) }}</h4>
                    <p class="mb-0">Monthly Sales</p>
                </div>
                <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
            </div>
            <div class="mt-2">
                <small><i class="fas fa-calendar-alt me-1"></i>{{ date('F Y') }}</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Monthly Milk Production Chart -->
    <div class="col-xl-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Monthly Milk Production</h5>
            </div>
            <div class="card-body">
                <canvas id="milkProductionChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="col-xl-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-primary">{{ number_format($monthlyMilk, 1) }}L</h4>
                        <small class="text-muted">Monthly Milk</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success">{{ $upcomingCheckups->count() }}</h4>
                        <small class="text-muted">Checkups Due</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-warning">{{ $upcomingCalving->count() }}</h4>
                        <small class="text-muted">Calving Expected</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-info">{{ $recentSales->count() }}</h4>
                        <small class="text-muted">Recent Sales</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.cattle.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Add New Cattle
                    </a>
                    <a href="{{ route('admin.milk-production.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i>Record Milk Production
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Milk Productions -->
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-glass-whiskey me-2"></i>Recent Milk Productions</h5>
                <a href="{{ route('admin.milk-production.index') }}" class="btn btn-sm btn-outline-light">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentMilkProductions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Cattle</th>
                                    <th>Farmer</th>
                                    <th>Total (L)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMilkProductions as $production)
                                <tr>
                                    <td>{{ $production->production_date->format('M d') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cow text-primary me-2"></i>
                                            {{ $production->cattle->name }}
                                        </div>
                                    </td>
                                    <td>{{ $production->user->name }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ number_format($production->total_milk, 1) }}L</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-glass-whiskey fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No milk production records yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Sales -->
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Recent Sales</h5>
                <a href="{{ route('admin.sales.index') }}" class="btn btn-sm btn-outline-light">View All</a>
            </div>
            <div class="card-body p-0">
                @if($recentSales->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Buyer</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->sale_date->format('M d') }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($sale->sale_type) }}</span>
                                    </td>
                                    <td>{{ $sale->buyer_name }}</td>
                                    <td>
                                        <span class="text-success fw-bold">${{ number_format($sale->total_amount, 2) }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No sales records yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Events -->
@if($upcomingCheckups->count() > 0 || $upcomingCalving->count() > 0)
<div class="row">
    @if($upcomingCheckups->count() > 0)
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Upcoming Health Checkups</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Cattle</th>
                                <th>Farmer</th>
                                <th>Due Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingCheckups as $checkup)
                            <tr>
                                <td>{{ $checkup->cattle->name }}</td>
                                <td>{{ $checkup->user->name }}</td>
                                <td>
                                    <span class="badge bg-warning">{{ $checkup->next_checkup_date->format('M d') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.health-records.show', $checkup->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if($upcomingCalving->count() > 0)
    <div class="col-xl-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Expected Calving</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Cattle</th>
                                <th>Farmer</th>
                                <th>Expected Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingCalving as $breeding)
                            <tr>
                                <td>{{ $breeding->cattle->name }}</td>
                                <td>{{ $breeding->user->name }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $breeding->expected_calving_date->format('M d') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.breeding-records.show', $breeding->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif
@endsection

@push('scripts')
<script>
    // Milk Production Chart
    const ctx = document.getElementById('milkProductionChart').getContext('2d');
    const milkData = @json($monthlyMilkData);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: milkData.map(item => item.month),
            datasets: [{
                label: 'Milk Production (Liters)',
                data: milkData.map(item => item.milk),
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                }
            }
        }
    });
</script>
@endpush
