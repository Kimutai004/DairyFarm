@extends('admin.layout')

@section('page-title', 'Record Milk Production')

@section('content')
<div class="production-form-container">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-0">🥛 Record Milk Production</h4>
                <p class="text-muted">Record daily milk production data</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.milk-production.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <h5 class="mb-0">Production Information</h5>
            <p class="text-muted mb-0">Fill in the production details below</p>
        </div>

        <form action="{{ route('admin.milk-production.store') }}" method="POST" class="production-form">
            @csrf
            
            <div class="form-body">
                <div class="row g-4">
                    <!-- Date and Basic Info -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="production_date" class="form-label required">Production Date</label>
                            <input type="date" 
                                   class="form-control @error('production_date') is-invalid @enderror" 
                                   id="production_date" 
                                   name="production_date" 
                                   value="{{ old('production_date', date('Y-m-d')) }}" 
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('production_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cattle_id" class="form-label required">Select Cattle</label>
                            <select class="form-select @error('cattle_id') is-invalid @enderror" 
                                    id="cattle_id" 
                                    name="cattle_id" 
                                    required>
                                <option value="">Choose cattle...</option>
                                @foreach($cattle as $animal)
                                    <option value="{{ $animal->id }}" 
                                            data-breed="{{ $animal->breed }}"
                                            {{ old('cattle_id') == $animal->id ? 'selected' : '' }}>
                                        {{ $animal->tag_number }} - {{ ucfirst($animal->breed) }}
                                        @if($animal->assignedUser)
                                            ({{ $animal->assignedUser->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('cattle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Only active female cattle are shown</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id" class="form-label required">Farmer</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" 
                                    id="user_id" 
                                    name="user_id" 
                                    required>
                                <option value="">Select farmer...</option>
                                @foreach($farmers as $farmer)
                                    <option value="{{ $farmer->id }}" {{ old('user_id') == $farmer->id ? 'selected' : '' }}>
                                        {{ $farmer->name }} ({{ $farmer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quality_grade" class="form-label required">Quality Grade</label>
                            <select class="form-select @error('quality_grade') is-invalid @enderror" 
                                    id="quality_grade" 
                                    name="quality_grade" 
                                    required>
                                <option value="">Select quality...</option>
                                <option value="A" {{ old('quality_grade') == 'A' ? 'selected' : '' }}>
                                    Grade A - Premium Quality
                                </option>
                                <option value="B" {{ old('quality_grade') == 'B' ? 'selected' : '' }}>
                                    Grade B - Good Quality
                                </option>
                                <option value="C" {{ old('quality_grade') == 'C' ? 'selected' : '' }}>
                                    Grade C - Standard Quality
                                </option>
                            </select>
                            @error('quality_grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Milk Production Amounts -->
                    <div class="col-12">
                        <h6 class="form-section-title">
                            <i class="fas fa-glass-whiskey me-2"></i>Milk Production (Liters)
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="morning_milk" class="form-label required">Morning Collection</label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('morning_milk') is-invalid @enderror" 
                                       id="morning_milk" 
                                       name="morning_milk" 
                                       value="{{ old('morning_milk') }}" 
                                       step="0.1"
                                       min="0"
                                       placeholder="0.0"
                                       required>
                                <span class="input-group-text">L</span>
                            </div>
                            @error('morning_milk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="evening_milk" class="form-label required">Evening Collection</label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('evening_milk') is-invalid @enderror" 
                                       id="evening_milk" 
                                       name="evening_milk" 
                                       value="{{ old('evening_milk') }}" 
                                       step="0.1"
                                       min="0"
                                       placeholder="0.0"
                                       required>
                                <span class="input-group-text">L</span>
                            </div>
                            @error('evening_milk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Total Display -->
                    <div class="col-12">
                        <div class="total-display">
                            <div class="total-card">
                                <h6 class="mb-2">Total Daily Production</h6>
                                <div class="total-amount" id="totalAmount">0.0 L</div>
                                <small class="text-muted">Morning + Evening</small>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3"
                                      placeholder="Any additional notes about the production (optional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Optional observations or remarks</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.milk-production.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Record Production
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.production-form-container {
    padding: 0;
}

.page-header {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.form-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.form-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.form-header h5 {
    color: #333;
    font-weight: 700;
}

.form-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-label.required::after {
    content: '*';
    color: #dc3545;
    margin-left: 4px;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-section-title {
    color: #333;
    font-weight: 600;
    padding: 1rem 0 0.5rem;
    border-top: 1px solid #e9ecef;
    margin-top: 1rem;
}

.input-group-text {
    background: #f8f9fa;
    border: 1px solid #e0e0e0;
    color: #6c757d;
    font-weight: 500;
}

.total-display {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    color: white;
    margin: 1rem 0;
}

.total-card h6 {
    margin: 0;
    opacity: 0.9;
}

.total-amount {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0.5rem 0;
}

.form-footer {
    background: #f8f9fa;
    padding: 1.5rem 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .form-footer {
        padding: 1.5rem;
    }
    
    .form-footer .d-flex {
        flex-direction: column-reverse;
        gap: 1rem;
    }
    
    .total-amount {
        font-size: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const morningInput = document.getElementById('morning_milk');
    const eveningInput = document.getElementById('evening_milk');
    const totalDisplay = document.getElementById('totalAmount');
    const cattleSelect = document.getElementById('cattle_id');
    const userSelect = document.getElementById('user_id');

    // Calculate total milk production
    function calculateTotal() {
        const morning = parseFloat(morningInput.value) || 0;
        const evening = parseFloat(eveningInput.value) || 0;
        const total = morning + evening;
        totalDisplay.textContent = total.toFixed(1) + ' L';
        
        // Update color based on production level
        if (total === 0) {
            totalDisplay.parentElement.parentElement.style.background = 'linear-gradient(135deg, #6c757d 0%, #495057 100%)';
        } else if (total < 10) {
            totalDisplay.parentElement.parentElement.style.background = 'linear-gradient(135deg, #fd7e14 0%, #e63946 100%)';
        } else if (total < 20) {
            totalDisplay.parentElement.parentElement.style.background = 'linear-gradient(135deg, #ffc107 0%, #fd7e14 100%)';
        } else {
            totalDisplay.parentElement.parentElement.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
        }
    }

    // Auto-assign farmer based on cattle selection
    function assignFarmer() {
        const selectedOption = cattleSelect.options[cattleSelect.selectedIndex];
        const cattleId = selectedOption.value;
        
        if (cattleId) {
            // You can extend this to automatically select the assigned farmer
            // For now, we'll just clear the selection to let user choose
        }
    }

    // Event listeners
    if (morningInput && eveningInput) {
        morningInput.addEventListener('input', calculateTotal);
        eveningInput.addEventListener('input', calculateTotal);
    }

    if (cattleSelect) {
        cattleSelect.addEventListener('change', assignFarmer);
    }

    // Initialize calculation
    calculateTotal();

    // Form validation
    const form = document.querySelector('.production-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // Validate milk amounts
            const morning = parseFloat(morningInput.value) || 0;
            const evening = parseFloat(eveningInput.value) || 0;
            
            if (morning < 0 || evening < 0) {
                alert('Milk amounts cannot be negative.');
                isValid = false;
            }

            if (morning + evening === 0) {
                if (!confirm('Total production is 0. Are you sure you want to continue?')) {
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush
@endsection
