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
                            <i class="fas fa-plus me-2"></i>
                            Record Milk Production
                        </h2>
                        <p class="page-subtitle">Add new milk production record</p>
                    </div>
                    <a href="{{ route('milk-production.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Records
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-glass-whiskey me-2"></i>Production Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('milk-production.store') }}">
                        @csrf

                        <div class="row g-3">
                            <!-- Production Date -->
                            <div class="col-md-6">
                                <label for="production_date" class="form-label">Production Date</label>
                                <input id="production_date" type="date" class="form-control @error('production_date') is-invalid @enderror" 
                                       name="production_date" value="{{ old('production_date', date('Y-m-d')) }}" required>
                                @error('production_date')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Cattle Selection -->
                            <div class="col-md-6">
                                <label for="cattle_id" class="form-label">Select Cattle</label>
                                <select id="cattle_id" class="form-select @error('cattle_id') is-invalid @enderror" name="cattle_id" required>
                                    <option value="">Choose cattle...</option>
                                    @foreach($cattle as $cow)
                                        <option value="{{ $cow->id }}" {{ old('cattle_id') == $cow->id ? 'selected' : '' }}>
                                            {{ $cow->tag_number }} - {{ ucfirst($cow->breed) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cattle_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                @if($cattle->count() == 0)
                                    <div class="form-text text-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        No female cattle available. Please add cattle first.
                                    </div>
                                @endif
                            </div>

                            <!-- Morning Milk -->
                            <div class="col-md-6">
                                <label for="morning_milk" class="form-label">Morning Milk (Liters)</label>
                                <div class="input-group">
                                    <input id="morning_milk" type="number" step="0.1" min="0" 
                                           class="form-control @error('morning_milk') is-invalid @enderror" 
                                           name="morning_milk" value="{{ old('morning_milk') }}" required
                                           placeholder="0.0">
                                    <span class="input-group-text">L</span>
                                </div>
                                @error('morning_milk')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Evening Milk -->
                            <div class="col-md-6">
                                <label for="evening_milk" class="form-label">Evening Milk (Liters)</label>
                                <div class="input-group">
                                    <input id="evening_milk" type="number" step="0.1" min="0" 
                                           class="form-control @error('evening_milk') is-invalid @enderror" 
                                           name="evening_milk" value="{{ old('evening_milk') }}" required
                                           placeholder="0.0">
                                    <span class="input-group-text">L</span>
                                </div>
                                @error('evening_milk')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Total Display -->
                            <div class="col-md-12">
                                <div class="total-display">
                                    <label class="form-label">Total Daily Production</label>
                                    <div class="total-amount">
                                        <span id="total_milk">0.0</span> L
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes (Optional)</label>
                                <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          name="notes" rows="3" placeholder="Any additional notes about today's production...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                Save Production Record
                            </button>
                            <a href="{{ route('milk-production.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="col-lg-4">
            <div class="farmer-card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar me-2"></i>Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="stats-list">
                        <div class="stat-item">
                            <div class="stat-label">Available Cattle</div>
                            <div class="stat-value">{{ $cattle->count() }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Today's Records</div>
                            <div class="stat-value">
                                {{ \App\Models\MilkProduction::where('user_id', auth()->id())->whereDate('production_date', today())->count() }}
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Yesterday's Total</div>
                            <div class="stat-value">
                                {{ number_format(\App\Models\MilkProduction::where('user_id', auth()->id())->whereDate('production_date', today()->subDay())->sum('total_milk'), 1) }}L
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Records -->
            <div class="farmer-card mt-3">
                <div class="card-header">
                    <h5><i class="fas fa-clock me-2"></i>Recent Records</h5>
                </div>
                <div class="card-body">
                    @php
                        $recentRecords = \App\Models\MilkProduction::where('user_id', auth()->id())
                            ->with('cattle')
                            ->latest('production_date')
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @forelse($recentRecords as $record)
                    <div class="recent-item">
                        <div class="recent-info">
                            <strong>{{ $record->cattle->tag_number }}</strong>
                            <span class="text-muted">{{ $record->production_date->format('M d') }}</span>
                        </div>
                        <div class="recent-amount">{{ number_format($record->total_milk, 1) }}L</div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-info-circle mb-2"></i>
                        <p>No recent records</p>
                    </div>
                    @endforelse
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

.total-display {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 1.5rem;
    border-radius: 15px;
    text-align: center;
}

.total-display .form-label {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0.5rem;
}

.total-amount {
    font-size: 2.5rem;
    font-weight: 700;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.stat-label {
    font-weight: 500;
    color: #6c757d;
}

.stat-value {
    font-weight: 700;
    color: #495057;
    margin-left: auto;
}

.recent-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-info {
    display: flex;
    flex-direction: column;
}

.recent-amount {
    font-weight: 700;
    color: #28a745;
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const morningInput = document.getElementById('morning_milk');
    const eveningInput = document.getElementById('evening_milk');
    const totalDisplay = document.getElementById('total_milk');

    function updateTotal() {
        const morning = parseFloat(morningInput.value) || 0;
        const evening = parseFloat(eveningInput.value) || 0;
        const total = morning + evening;
        totalDisplay.textContent = total.toFixed(1);
    }

    morningInput.addEventListener('input', updateTotal);
    eveningInput.addEventListener('input', updateTotal);
});
</script>
@endsection
