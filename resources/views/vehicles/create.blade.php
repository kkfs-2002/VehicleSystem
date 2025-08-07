@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #4361ee;
        --primary-hover: #3a56d4;
        --secondary-color: #6c757d;
        --border-color: #e0e6ed;
        --text-dark: #2c3e50;
        --text-light: #6c757d;
        --bg-light: #f8f9fa;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #fd7e14;
    }

    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-container {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .form-header {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 2rem;
        color: var(--text-dark);
        position: relative;
        padding-bottom: 1rem;
    }

    .form-header:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    label.required::after {
        content: " *";
        color: var(--danger-color);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        padding: 0.65rem 0.85rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        height: calc(2.25rem + 8px);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .preview-container {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-light);
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
    }

    .preview-container:hover {
        border-color: var(--primary-color);
    }

    .preview-image {
        max-height: 100%;
        max-width: 100%;
        object-fit: cover;
    }

    .form-text {
        font-size: 0.82rem;
        color: var(--text-light);
        margin-top: 0.35rem;
    }

    .btn {
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        color: var(--secondary-color);
        border-color: var(--border-color);
    }

    .btn-outline-secondary:hover {
        background-color: var(--bg-light);
        color: var(--text-dark);
        border-color: var(--border-color);
    }

    .alert {
        border-radius: 8px;
        font-size: 0.95rem;
        border: none;
        padding: 1rem 1.25rem;
    }

    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
    }

    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: var(--danger-color);
    }

    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: var(--bg-light);
    }

    .progress-bar {
        background-color: var(--primary-color);
        transition: width 0.4s ease;
    }

    .submit-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .submit-btn i {
        font-size: 1.1rem;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 1.5rem 0 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .input-group-text {
        background-color: var(--bg-light);
        border: 1px solid var(--border-color);
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .form-floating>label {
        padding: 0.85rem 0.75rem;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1.75rem;
        }
        
        .form-header {
            font-size: 1.5rem;
        }
    }

    /* Floating animation for submit button */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-3px); }
        100% { transform: translateY(0px); }
    }

    .submit-btn:hover {
        animation: float 1.5s ease infinite;
    }

    /* Ripple effect for buttons */
    .btn-ripple {
        position: relative;
        overflow: hidden;
    }

    .btn-ripple:after {
        content: "";
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
        background-repeat: no-repeat;
        background-position: 50%;
        transform: scale(10, 10);
        opacity: 0;
        transition: transform .5s, opacity 1s;
    }

    .btn-ripple:active:after {
        transform: scale(0, 0);
        opacity: .3;
        transition: 0s;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="form-container">
                <h2 class="form-header"><i class="bi bi-car-front-fill me-2"></i>Add New Vehicle</h2>
                
                <div id="response-message" class="d-none alert mb-4"></div>
                
                <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="section-title">Vehicle Image</div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label required">Vehicle Image</label>
                                <div class="preview-container mb-3" id="imagePreview">
                                    <span class="text-muted">No image selected</span>
                                </div>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                <div class="form-text">Recommended size: 800x600px. Max file size: 5MB (JPG, PNG, GIF)</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label required">Vehicle Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Toyota Camry 2022" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label required">Price (RS)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">RS</span>
                                        <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" placeholder="0.00" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="year" class="form-label required">Year</label>
                                    <input type="number" class="form-control" id="year" name="year" min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g., 2022" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="brand" class="form-label required">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand" placeholder="e.g., Toyota" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="model" class="form-label required">Model</label>
                                    <input type="text" class="form-control" id="model" name="model" placeholder="e.g., Camry" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-title">Specifications</div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="mileage" class="form-label">Mileage (km)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="mileage" name="mileage" min="0" placeholder="e.g., 15000">
                                <span class="input-group-text">km</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="e.g., Metallic Red">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="seats" class="form-label">Seats</label>
                            <input type="number" class="form-control" id="seats" name="seats" min="1" max="20" placeholder="e.g., 5">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fuel" class="form-label required">Fuel Type</label>
                            <select class="form-select" id="fuel" name="fuel" required>
                                <option value="" disabled selected>Select fuel type</option>
                                <option value="petrol">Petrol</option>
                                <option value="diesel">Diesel</option>
                                <option value="electric">Electric</option>
                                <option value="hybrid">Hybrid</option>
                                <option value="cng">CNG</option>
                                <option value="lpg">LPG</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="transmission" class="form-label required">Transmission</label>
                            <select class="form-select" id="transmission" name="transmission" required>
                                <option value="" disabled selected>Select transmission</option>
                                <option value="automatic">Automatic</option>
                                <option value="manual">Manual</option>
                                <option value="semi-automatic">Semi-Automatic</option>
                                <option value="cvt">CVT</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="section-title">Additional Information</div>
                    <div class="mb-4">
                        <label for="details" class="form-label">Vehicle Description</label>
                        <textarea class="form-control" id="details" name="details" rows="4" placeholder="Enter detailed description about the vehicle including features, condition, etc..."></textarea>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-3 d-none" id="progress-container">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Uploading...</small>
                            <small class="text-muted" id="progress-percentage">0%</small>
                        </div>
                        <div class="progress">
                            <div id="upload-progress" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-ripple">
                            <i class="bi bi-arrow-left me-1"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary submit-btn btn-ripple">
                            <i class="bi bi-plus-circle me-1"></i> Add Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced image preview functionality
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Check file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                showResponseMessage('danger', 'File size exceeds 5MB limit');
                this.value = '';
                imagePreview.innerHTML = '<span class="text-muted">No image selected</span>';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
                }
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.innerHTML = '<span class="text-muted">No image selected</span>';
        }
    });
    
    // Form validation and submission
    document.getElementById('vehicleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        const requiredFields = this.querySelectorAll('[required]');
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
            showResponseMessage('danger', 'Please fill all required fields');
            return;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('.submit-btn');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Processing...';
        submitBtn.disabled = true;
        
        // Show progress bar
        document.getElementById('progress-container').classList.remove('d-none');
        
        // Create FormData
        const formData = new FormData(this);
        const url = this.action;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const xhr = new XMLHttpRequest();
        
        // Progress handling
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                document.getElementById('upload-progress').style.width = `${percent}%`;
                document.getElementById('progress-percentage').textContent = `${percent}%`;
            }
        });
        
        xhr.addEventListener('load', function() {
            let response;
            try {
                response = JSON.parse(xhr.responseText);
            } catch (e) {
                console.error('JSON parse error:', e);
                showResponseMessage('danger', 'Invalid server response. Please try again.');
                resetButton();
                return;
            }
            
            if (xhr.status >= 200 && xhr.status < 300) {
                if (response.status === 'success') {
                    // Show success message with custom buttons
                    showResponseMessage(
                        'success', 
                        `<strong>Success!</strong> ${response.message}`,
                        `<div class="mt-3 d-flex gap-2">
                            <a href="/vehicles" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-list-ul me-1"></i> View All Vehicles
                            </a>
                            <button onclick="location.reload()" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Add Another
                            </button>
                        </div>`
                    );
                    
                    // Reset form
                    document.getElementById('vehicleForm').reset();
                    document.getElementById('imagePreview').innerHTML = '<span class="text-muted">No image selected</span>';
                } else {
                    showResponseMessage('danger', response.message || 'Operation failed. Please try again.');
                }
            } else {
                let errorMsg = response.message || `Error ${xhr.status}: Please try again`;
                
                // Show validation errors if any
                if (response.errors) {
                    errorMsg += '<ul class="mt-2 mb-0 ps-3">';
                    for (const field in response.errors) {
                        errorMsg += `<li>${response.errors[field].join(', ')}</li>`;
                        // Highlight invalid fields
                        const inputField = document.querySelector(`[name="${field}"]`);
                        if (inputField) {
                            inputField.classList.add('is-invalid');
                        }
                    }
                    errorMsg += '</ul>';
                }
                
                showResponseMessage('danger', errorMsg);
            }
            
            resetButton();
        });
        
        xhr.addEventListener('error', function() {
            showResponseMessage('danger', 'Network error - please check your internet connection');
            resetButton();
        });
        
        xhr.open('POST', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', token);
        xhr.send(formData);
        
        function showResponseMessage(type, message, extraContent = '') {
            const responseMessage = document.getElementById('response-message');
            responseMessage.className = `alert alert-${type} fade show`;
            responseMessage.innerHTML = `
                <div class="d-flex align-items-center">
                    ${type === 'success' ? 
                        '<i class="bi bi-check-circle-fill me-2 fs-5"></i>' : 
                        '<i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>'}
                    <div>
                        ${message}
                        ${extraContent}
                    </div>
                </div>
            `;
            responseMessage.classList.remove('d-none');
            
            // Smooth scroll to message
            responseMessage.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }
        
        function resetButton() {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            document.getElementById('progress-container').classList.add('d-none');
            document.getElementById('upload-progress').style.width = '0%';
            document.getElementById('progress-percentage').textContent = '0%';
        }
    });
    
    // Remove invalid class when user starts typing
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
            }
        });
    });
</script>
@endsection