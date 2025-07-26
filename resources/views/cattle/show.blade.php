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
                                    Cattle Details: {{ $cattle->tag_number }}
                                </h2>
                                <p class="page-subtitle">View detailed information about this cattle</p>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('cattle.edit', $cattle) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit
                                </a>
                                <a href="{{ route('cattle.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Basic Information -->
                <div class="col-lg-6">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="cattle-detail-item">
                                <label>Tag Number</label>
                                <span class="badge bg-primary">{{ $cattle->tag_number }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Name</label>
                                <span>{{ $cattle->name ?? 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Breed</label>
                                <span>{{ ucfirst($cattle->breed) }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Gender</label>
                                <span class="badge {{ $cattle->gender == 'male' ? 'bg-info' : 'bg-pink' }}">
                                    {{ ucfirst($cattle->gender) }}
                                </span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Birth Date</label>
                                <span>{{ $cattle->birth_date ? $cattle->birth_date->format('M d, Y') : 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Age</label>
                                <span>
                                    @if($cattle->birth_date)
                                        {{ $cattle->birth_date->diffInYears(now()) }} years old
                                    @else
                                        Not calculated
                                    @endif
                                </span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Weight</label>
                                <span>{{ $cattle->weight ? $cattle->weight . ' kg' : 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Status</label>
                                <span class="badge {{ $cattle->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($cattle->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="col-lg-6">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-clipboard-list me-2"></i>Additional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="cattle-detail-item">
                                <label>Purchase Date</label>
                                <span>{{ $cattle->purchase_date ? $cattle->purchase_date->format('M d, Y') : 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Purchase Price</label>
                                <span>{{ $cattle->purchase_price ? '$' . number_format($cattle->purchase_price, 2) : 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Mother Tag</label>
                                <span>{{ $cattle->mother_tag ?? 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Father Tag</label>
                                <span>{{ $cattle->father_tag ?? 'Not specified' }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Registration Date</label>
                                <span>{{ $cattle->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="cattle-detail-item">
                                <label>Last Updated</label>
                                <span>{{ $cattle->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                            
                            @if($cattle->notes)
                                <div class="cattle-detail-item">
                                    <label>Notes</label>
                                    <div class="notes-content">
                                        {{ $cattle->notes }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-tasks me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="action-buttons">
                                <a href="{{ route('milk-production.create') }}?cattle_id={{ $cattle->id }}" class="action-btn primary">
                                    <i class="fas fa-glass-whiskey"></i>
                                    <span>Record Milk Production</span>
                                </a>
                                <a href="{{ route('health-records.create') }}?cattle_id={{ $cattle->id }}" class="action-btn success">
                                    <i class="fas fa-heartbeat"></i>
                                    <span>Health Check</span>
                                </a>
                                <a href="{{ route('feed-records.create') }}?cattle_id={{ $cattle->id }}" class="action-btn warning">
                                    <i class="fas fa-wheat-awn"></i>
                                    <span>Feed Record</span>
                                </a>
                                <a href="{{ route('breeding-records.create') }}?cattle_id={{ $cattle->id }}" class="action-btn info">
                                    <i class="fas fa-heart"></i>
                                    <span>Breeding Record</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hide default Laravel navbar for dashboard pages */
.navbar {
    display: none !important;
}

/* Adjust main content to account for no navbar */
main.py-4 {
    padding: 0 !important;
}

.cattle-detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.cattle-detail-item:last-child {
    border-bottom: none;
}

.cattle-detail-item label {
    font-weight: 600;
    color: #6c757d;
    margin: 0;
    min-width: 120px;
}

.cattle-detail-item span {
    color: #333;
    text-align: right;
}

.notes-content {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 6px;
    border-left: 3px solid #667eea;
    margin-top: 0.5rem;
    font-style: italic;
}

.bg-pink {
    background-color: #e83e8c !important;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.8rem;
    background: #f8f9fa;
    border: 2px solid transparent;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    font-size: 0.85rem;
}

.action-btn:hover {
    color: white;
    text-decoration: none;
}

.action-btn.primary:hover { background: #667eea; }
.action-btn.success:hover { background: #28a745; }
.action-btn.warning:hover { background: #ffc107; }
.action-btn.info:hover { background: #17a2b8; }

@media (max-width: 768px) {
    .cattle-detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .cattle-detail-item span {
        text-align: left;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
