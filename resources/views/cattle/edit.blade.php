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
                                    Edit Cattle: {{ $cattle->tag_number }}
                                </h2>
                                <p class="page-subtitle">Update cattle information</p>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('cattle.show', $cattle) }}" class="btn btn-info">
                                    <i class="fas fa-eye me-2"></i>
                                    View Details
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

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="farmer-card">
                        <div class="card-header">
                            <h5><i class="fas fa-cow me-2"></i>Update Cattle Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('cattle.update', $cattle) }}">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <!-- Tag Number -->
                                    <div class="col-md-6">
                                        <label for="tag_number" class="form-label">Tag Number *</label>
                                        <input id="tag_number" type="text" class="form-control @error('tag_number') is-invalid @enderror" 
                                               name="tag_number" value="{{ old('tag_number', $cattle->tag_number) }}" required
                                               placeholder="e.g., COW001">
                                        @error('tag_number')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name', $cattle->name) }}"
                                               placeholder="e.g., Bessie">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Breed -->
                                    <div class="col-md-6">
                                        <label for="breed" class="form-label">Breed *</label>
                                        <select id="breed" class="form-select @error('breed') is-invalid @enderror" name="breed" required>
                                            <option value="">Select Breed</option>
                                            <option value="holstein" {{ old('breed', $cattle->breed) == 'holstein' ? 'selected' : '' }}>Holstein</option>
                                            <option value="jersey" {{ old('breed', $cattle->breed) == 'jersey' ? 'selected' : '' }}>Jersey</option>
                                            <option value="guernsey" {{ old('breed', $cattle->breed) == 'guernsey' ? 'selected' : '' }}>Guernsey</option>
                                            <option value="ayrshire" {{ old('breed', $cattle->breed) == 'ayrshire' ? 'selected' : '' }}>Ayrshire</option>
                                            <option value="brown_swiss" {{ old('breed', $cattle->breed) == 'brown_swiss' ? 'selected' : '' }}>Brown Swiss</option>
                                            <option value="friesian" {{ old('breed', $cattle->breed) == 'friesian' ? 'selected' : '' }}>Friesian</option>
                                            <option value="angus" {{ old('breed', $cattle->breed) == 'angus' ? 'selected' : '' }}>Angus</option>
                                            <option value="hereford" {{ old('breed', $cattle->breed) == 'hereford' ? 'selected' : '' }}>Hereford</option>
                                            <option value="charolais" {{ old('breed', $cattle->breed) == 'charolais' ? 'selected' : '' }}>Charolais</option>
                                            <option value="simmental" {{ old('breed', $cattle->breed) == 'simmental' ? 'selected' : '' }}>Simmental</option>
                                            <option value="crossbred" {{ old('breed', $cattle->breed) == 'crossbred' ? 'selected' : '' }}>Crossbred</option>
                                            <option value="other" {{ old('breed', $cattle->breed) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('breed')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Gender *</label>
                                        <select id="gender" class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender', $cattle->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $cattle->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Birth Date -->
                                    <div class="col-md-6">
                                        <label for="birth_date" class="form-label">Birth Date</label>
                                        <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                               name="birth_date" value="{{ old('birth_date', $cattle->birth_date ? $cattle->birth_date->format('Y-m-d') : '') }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Weight -->
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Weight (kg)</label>
                                        <input id="weight" type="number" step="0.1" min="0" class="form-control @error('weight') is-invalid @enderror" 
                                               name="weight" value="{{ old('weight', $cattle->weight) }}"
                                               placeholder="e.g., 450.5">
                                        @error('weight')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Purchase Date -->
                                    <div class="col-md-6">
                                        <label for="purchase_date" class="form-label">Purchase Date</label>
                                        <input id="purchase_date" type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                               name="purchase_date" value="{{ old('purchase_date', $cattle->purchase_date ? $cattle->purchase_date->format('Y-m-d') : '') }}">
                                        @error('purchase_date')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Purchase Price -->
                                    <div class="col-md-6">
                                        <label for="purchase_price" class="form-label">Purchase Price ($)</label>
                                        <input id="purchase_price" type="number" step="0.01" min="0" class="form-control @error('purchase_price') is-invalid @enderror" 
                                               name="purchase_price" value="{{ old('purchase_price', $cattle->purchase_price) }}"
                                               placeholder="e.g., 1500.00">
                                        @error('purchase_price')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Mother Tag -->
                                    <div class="col-md-6">
                                        <label for="mother_tag" class="form-label">Mother Tag Number</label>
                                        <input id="mother_tag" type="text" class="form-control @error('mother_tag') is-invalid @enderror" 
                                               name="mother_tag" value="{{ old('mother_tag', $cattle->mother_tag) }}"
                                               placeholder="e.g., COW025">
                                        @error('mother_tag')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Father Tag -->
                                    <div class="col-md-6">
                                        <label for="father_tag" class="form-label">Father Tag Number</label>
                                        <input id="father_tag" type="text" class="form-control @error('father_tag') is-invalid @enderror" 
                                               name="father_tag" value="{{ old('father_tag', $cattle->father_tag) }}"
                                               placeholder="e.g., BULL008">
                                        @error('father_tag')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status *</label>
                                        <select id="status" class="form-select @error('status') is-invalid @enderror" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="active" {{ old('status', $cattle->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="sold" {{ old('status', $cattle->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                            <option value="deceased" {{ old('status', $cattle->status) == 'deceased' ? 'selected' : '' }}>Deceased</option>
                                            <option value="transferred" {{ old('status', $cattle->status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Notes -->
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                                  name="notes" rows="4" 
                                                  placeholder="Any additional notes about this cattle...">{{ old('notes', $cattle->notes) }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                                <i class="fas fa-save me-2"></i>
                                                Update Cattle
                                            </button>
                                            <a href="{{ route('cattle.show', $cattle) }}" class="btn btn-light btn-lg">
                                                <i class="fas fa-times me-2"></i>
                                                Cancel
                                            </a>
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

<style>
/* Hide default Laravel navbar for dashboard pages */
.navbar {
    display: none !important;
}

/* Adjust main content to account for no navbar */
main.py-4 {
    padding: 0 !important;
}
</style>
@endsection
