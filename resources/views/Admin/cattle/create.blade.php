@extends('admin.layout')

@section('page-title', 'Add New Cattle')

@section('content')
<div class="cattle-form-container">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h4 class="page-title mb-0">🐄 Add New Cattle</h4>
                <p class="text-muted">Register a new cattle in the system</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.cattle.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <h5 class="mb-0">Cattle Information</h5>
            <p class="text-muted mb-0">Fill in the details below</p>
        </div>

        <form action="{{ route('admin.cattle.store') }}" method="POST" class="cattle-form">
            @csrf
            
            <div class="form-body">
                <div class="row g-4">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tag_number" class="form-label required">Tag Number</label>
                            <input type="text" 
                                   class="form-control @error('tag_number') is-invalid @enderror" 
                                   id="tag_number" 
                                   name="tag_number" 
                                   value="{{ old('tag_number') }}" 
                                   placeholder="e.g., C001, COW-2024-001"
                                   required>
                            @error('tag_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Unique identifier for the cattle</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="breed" class="form-label required">Breed</label>
                            <select class="form-select @error('breed') is-invalid @enderror" 
                                    id="breed" 
                                    name="breed" 
                                    required>
                                <option value="">Select Breed</option>
                                <option value="holstein" {{ old('breed') == 'holstein' ? 'selected' : '' }}>Holstein</option>
                                <option value="jersey" {{ old('breed') == 'jersey' ? 'selected' : '' }}>Jersey</option>
                                <option value="friesian" {{ old('breed') == 'friesian' ? 'selected' : '' }}>Friesian</option>
                                <option value="guernsey" {{ old('breed') == 'guernsey' ? 'selected' : '' }}>Guernsey</option>
                                <option value="brown_swiss" {{ old('breed') == 'brown_swiss' ? 'selected' : '' }}>Brown Swiss</option>
                                <option value="ayrshire" {{ old('breed') == 'ayrshire' ? 'selected' : '' }}>Ayrshire</option>
                                <option value="other" {{ old('breed') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('breed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gender" class="form-label required">Gender</label>
                            <div class="gender-options">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" 
                                           type="radio" 
                                           name="gender" 
                                           id="female" 
                                           value="female" 
                                           {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">
                                        <i class="fas fa-venus me-1"></i>Female
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" 
                                           type="radio" 
                                           name="gender" 
                                           id="male" 
                                           value="male" 
                                           {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">
                                        <i class="fas fa-mars me-1"></i>Male
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_of_birth" class="form-label required">Date of Birth</label>
                            <input type="date" 
                                   class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" 
                                   name="date_of_birth" 
                                   value="{{ old('date_of_birth') }}" 
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" 
                                   class="form-control @error('weight') is-invalid @enderror" 
                                   id="weight" 
                                   name="weight" 
                                   value="{{ old('weight') }}" 
                                   step="0.1"
                                   min="0"
                                   placeholder="e.g., 450.5">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Optional - Current weight in kilograms</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assigned_to" class="form-label">Assign to Farmer</label>
                            <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                    id="assigned_to" 
                                    name="assigned_to">
                                <option value="">Select Farmer (Optional)</option>
                                @foreach($farmers as $farmer)
                                    <option value="{{ $farmer->id }}" {{ old('assigned_to') == $farmer->id ? 'selected' : '' }}>
                                        {{ $farmer->name }} ({{ $farmer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Assign cattle to a specific farmer</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status" class="form-label required">Status</label>
                            <div class="status-options">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="active" 
                                           value="active" 
                                           {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        <span class="status-indicator active"></span>Active
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="inactive" 
                                           value="inactive" 
                                           {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inactive">
                                        <span class="status-indicator inactive"></span>Inactive
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="sold" 
                                           value="sold" 
                                           {{ old('status') == 'sold' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sold">
                                        <span class="status-indicator sold"></span>Sold
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="status" 
                                           id="deceased" 
                                           value="deceased" 
                                           {{ old('status') == 'deceased' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="deceased">
                                        <span class="status-indicator deceased"></span>Deceased
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.cattle.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Register Cattle
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.cattle-form-container {
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

.gender-options, .status-options {
    display: flex;
    gap: 2rem;
    margin-top: 0.5rem;
}

.form-check-label {
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 0.5rem;
}

.status-indicator.active {
    background: #28a745;
}

.status-indicator.inactive {
    background: #dc3545;
}

.status-indicator.sold {
    background: #17a2b8;
}

.status-indicator.deceased {
    background: #6c757d;
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
    
    .gender-options, .status-options {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-footer .d-flex {
        flex-direction: column-reverse;
        gap: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate tag number suggestion
    const tagInput = document.getElementById('tag_number');
    const breedSelect = document.getElementById('breed');
    
    if (tagInput && breedSelect) {
        breedSelect.addEventListener('change', function() {
            if (!tagInput.value && this.value) {
                const breedCode = this.value.substring(0, 3).toUpperCase();
                const year = new Date().getFullYear();
                const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                tagInput.placeholder = `${breedCode}-${year}-${random}`;
            }
        });
    }

    // Form validation
    const form = document.querySelector('.cattle-form');
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

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    }
});
</script>
@endpush
@endsection
