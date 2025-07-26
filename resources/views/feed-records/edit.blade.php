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
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Feed Record
                                </h2>
                                <p class="page-subtitle">Update feeding record for {{ $feedRecord->feeding_date->format('F j, Y') }}</p>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('feed-records.show', $feedRecord->id) }}" class="btn btn-light btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Details
                                </a>
                                <a href="{{ route('feed-records.index') }}" class="btn btn-outline-light btn-lg">
                                    <i class="fas fa-list me-2"></i>
                                    All Records
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-wheat-awn me-2"></i>Update Feed Record Details</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('feed-records.update', $feedRecord->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <!-- Cattle Selection -->
                                    <div class="col-md-6">
                                        <label for="cattle_id" class="form-label">
                                            <i class="fas fa-cow me-2"></i>Select Cattle
                                        </label>
                                        <select class="form-select @error('cattle_id') is-invalid @enderror" id="cattle_id" name="cattle_id" required>
                                            <option value="">Choose cattle...</option>
                                            @foreach($cattle as $cow)
                                                <option value="{{ $cow->id }}" {{ old('cattle_id', $feedRecord->cattle_id) == $cow->id ? 'selected' : '' }}>
                                                    {{ $cow->tag_number }} - {{ $cow->name ?? 'N/A' }} ({{ ucfirst($cow->breed) }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cattle_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Feeding Date -->
                                    <div class="col-md-6">
                                        <label for="feeding_date" class="form-label">
                                            <i class="fas fa-calendar-alt me-2"></i>Feeding Date
                                        </label>
                                        <input type="date" class="form-control @error('feeding_date') is-invalid @enderror" 
                                               id="feeding_date" name="feeding_date" 
                                               value="{{ old('feeding_date', $feedRecord->feeding_date->format('Y-m-d')) }}" required>
                                        @error('feeding_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Feed Type -->
                                    <div class="col-md-6">
                                        <label for="feed_type" class="form-label">
                                            <i class="fas fa-wheat-awn me-2"></i>Feed Type
                                        </label>
                                        <select class="form-select @error('feed_type') is-invalid @enderror" id="feed_type" name="feed_type" required>
                                            <option value="">Select feed type...</option>
                                            <option value="Hay" {{ old('feed_type', $feedRecord->feed_type) == 'Hay' ? 'selected' : '' }}>Hay</option>
                                            <option value="Silage" {{ old('feed_type', $feedRecord->feed_type) == 'Silage' ? 'selected' : '' }}>Silage</option>
                                            <option value="Grain" {{ old('feed_type', $feedRecord->feed_type) == 'Grain' ? 'selected' : '' }}>Grain</option>
                                            <option value="Pasture" {{ old('feed_type', $feedRecord->feed_type) == 'Pasture' ? 'selected' : '' }}>Pasture</option>
                                            <option value="Concentrate" {{ old('feed_type', $feedRecord->feed_type) == 'Concentrate' ? 'selected' : '' }}>Concentrate</option>
                                            <option value="Supplements" {{ old('feed_type', $feedRecord->feed_type) == 'Supplements' ? 'selected' : '' }}>Supplements</option>
                                            <option value="Other" {{ old('feed_type', $feedRecord->feed_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('feed_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-6">
                                        <label for="quantity" class="form-label">
                                            <i class="fas fa-weight-hanging me-2"></i>Quantity
                                        </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                                   id="quantity" name="quantity" step="0.01" min="0"
                                                   value="{{ old('quantity', $feedRecord->quantity) }}" required>
                                            <span class="input-group-text">kg</span>
                                        </div>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div class="col-md-6">
                                        <label for="unit" class="form-label">
                                            <i class="fas fa-ruler me-2"></i>Unit
                                        </label>
                                        <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                            <option value="kg" {{ old('unit', 'kg') == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                            <option value="lbs" {{ old('unit') == 'lbs' ? 'selected' : '' }}>Pounds (lbs)</option>
                                            <option value="tons" {{ old('unit') == 'tons' ? 'selected' : '' }}>Tons</option>
                                            <option value="bales" {{ old('unit') == 'bales' ? 'selected' : '' }}>Bales</option>
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Cost per Unit -->
                                    <div class="col-md-6">
                                        <label for="cost_per_unit" class="form-label">
                                            <i class="fas fa-dollar-sign me-2"></i>Cost per Unit <span class="text-muted">(Optional)</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control @error('cost_per_unit') is-invalid @enderror" 
                                                   id="cost_per_unit" name="cost_per_unit" step="0.01" min="0"
                                                   value="{{ old('cost_per_unit', $feedRecord->cost_per_unit) }}">
                                        </div>
                                        @error('cost_per_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Total Cost -->
                                    <div class="col-md-12">
                                        <label for="total_cost" class="form-label">
                                            <i class="fas fa-calculator me-2"></i>Total Cost <span class="text-muted">(Auto-calculated or manual)</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control @error('total_cost') is-invalid @enderror" 
                                                   id="total_cost" name="total_cost" step="0.01" min="0"
                                                   value="{{ old('total_cost', $feedRecord->total_cost) }}" readonly>
                                        </div>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Total cost is automatically calculated when you enter quantity and cost per unit.
                                        </div>
                                        @error('total_cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <label for="notes" class="form-label">
                                            <i class="fas fa-sticky-note me-2"></i>Notes <span class="text-muted">(Optional)</span>
                                        </label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="3" 
                                                  placeholder="Any additional notes about this feeding...">{{ old('notes', $feedRecord->notes) }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('feed-records.show', $feedRecord->id) }}" class="btn btn-light btn-lg">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-save me-2"></i>
                                                Update Feed Record
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script>
    // Auto-calculate total cost
    function calculateTotalCost() {
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const costPerUnit = parseFloat(document.getElementById('cost_per_unit').value) || 0;
        const totalCostField = document.getElementById('total_cost');
        
        if (quantity > 0 && costPerUnit > 0) {
            const totalCost = quantity * costPerUnit;
            totalCostField.value = totalCost.toFixed(2);
            totalCostField.readOnly = true;
        } else {
            totalCostField.readOnly = false;
        }
    }

    // User dropdown toggle functionality
    function toggleUserDropdown() {
        const userInfo = document.getElementById('userInfo');
        const userDropdown = document.getElementById('userDropdown');
        
        userInfo.classList.toggle('active');
        userDropdown.classList.toggle('active');
    }

    function closeUserDropdown() {
        const userInfo = document.getElementById('userInfo');
        const userDropdown = document.getElementById('userDropdown');
        
        userInfo.classList.remove('active');
        userDropdown.classList.remove('active');
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate total cost on input change
        document.getElementById('quantity').addEventListener('input', calculateTotalCost);
        document.getElementById('cost_per_unit').addEventListener('input', calculateTotalCost);
        
        // Calculate on page load
        calculateTotalCost();
        
        // User dropdown
        document.getElementById('userInfo').addEventListener('click', function(e) {
            e.stopPropagation();
            toggleUserDropdown();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-info') && !e.target.closest('.user-dropdown')) {
                closeUserDropdown();
            }
        });

        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        });
    });
</script>

<style>
/* Hide navbar for this page */
.navbar {
    display: none !important;
}
</style>

@include('layouts.sidebar-styles')
@endsection
