@extends('layouts.app')

@section('content')
<head>
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-header h1 {
        font-weight: 600;
        color: #343a40;
    }

    .dashboard-card {
        border: none;
        background: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .card-icon {
        font-size: 1.8rem;
        padding: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .table th {
        font-weight: 600;
        font-size: 0.95rem;
        background: #f0f2f5;
    }

    .table td {
        vertical-align: middle;
    }

    .vehicle-image {
        width: 80px;
        height: auto;
        border-radius: 0.5rem;
        object-fit: cover;
    }

    .btn-sm i {
        font-size: 0.85rem;
    }

    .btn-outline-secondary {
        border: 1px solid #ced4da;
    }

    .modal-header {
        background-color: #2c3e50;
        color: #fff;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-body {
        background-color: #f9f9f9;
    }

    .vehicle-details-img {
        width: 100%;
        border-radius: 0.5rem;
    }

    .vehicle-detail-badge,
    .feature-badge {
        background: #eef1f4;
        border-radius: 6px;
        padding: 6px 10px;
        margin: 5px 5px 5px 0;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -6px;
        background-color: #dc3545;
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 50%;
    }

    .nav-tabs .nav-link.active {
        font-weight: bold;
        color: #0d6efd;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }

    .input-group input {
        border-right: 0;
    }

    .input-group .btn {
        border-left: 0;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-buttons form {
        margin: 0;
    }

    /* New styles for button states */
    .btn-approved {
        background-color: #d1e7dd;
        color: #0f5132;
        border-color: #badbcc;
    }

    .btn-pending {
        background-color: #fff3cd;
        color: #664d03;
        border-color: #ffecb5;
    }

    .btn-rejected {
        background-color: #f8d7da;
        color: #842029;
        border-color: #f5c2c7;
    }
</style>
</head>

<div class="container py-4">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1><i class="fas fa-car me-3"></i>Vehicle Management Dashboard</h1>
                <p class="mb-0">Manage vehicle listings and approvals</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="d-inline-block me-3 position-relative">
                    <button class="btn btn-light position-relative">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                </div>
                <div class="d-inline-block me-3">
                    <span class="badge bg-light text-dark p-2">
                        <i class="fas fa-user me-2"></i>Admin User
                    </span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="dashboard-card statistics-card total">
                <div class="card-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-car"></i>
                </div>
                <h5>Total Vehicles</h5>
                <h2 class="text-primary">{{ $totalVehicles }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card statistics-card approved">
                <div class="card-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5>Approved</h5>
                <h2 class="text-success">{{ $approvedVehicles }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card statistics-card pending">
                <div class="card-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <h5>Pending</h5>
                <h2 class="text-warning">{{ $pendingVehicles }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card statistics-card rejected">
                <div class="card-icon bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h5>Rejected</h5>
                <h2 class="text-danger">{{ $rejectedVehicles }}</h2>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Vehicles</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                Pending Approval <span class="badge bg-warning ms-1">{{ $pendingVehicles }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                Approved <span class="badge bg-success ms-1">{{ $approvedVehicles }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
                Rejected <span class="badge bg-danger ms-1">{{ $rejectedVehicles }}</span>
            </button>
        </li>
    </ul>

    <!-- Vehicle Table -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Vehicle Listings</h4>
            <div class="d-flex">
                <div class="input-group me-2" style="width: 250px;">
                    <input type="text" class="form-control" placeholder="Search vehicles..." id="searchInput">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary" id="addNewBtn">
                    <i class="fas fa-plus me-1"></i> Add New
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Vehicle</th>
                        <th>Ethical Price</th>
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td>#V{{ $vehicle->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $vehicle->image) }}" class="vehicle-image" alt="{{ $vehicle->name }}">
                        </td>
                        <td>
                            <strong>{{ $vehicle->name }}</strong>
                            <div class="text-muted small">{{ $vehicle->brand }} • {{ $vehicle->year }} • {{ number_format($vehicle->mileage) }} miles</div>
                        </td>
                        <td>
                            <strong>Rs{{ number_format($vehicle->price) }}</strong>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary view-details" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailsModal"
                                    data-vehicle-id="{{ $vehicle->id }}"
                                    data-vehicle-name="{{ $vehicle->name }}"
                                    data-vehicle-image="{{ asset('storage/' . $vehicle->image) }}"
                                    data-vehicle-price="{{ $vehicle->price }}"
                                    data-vehicle-year="{{ $vehicle->year }}"
                                    data-vehicle-brand="{{ $vehicle->brand }}"
                                    data-vehicle-model="{{ $vehicle->model }}"
                                    data-vehicle-mileage="{{ $vehicle->mileage }}"
                                    data-vehicle-color="{{ $vehicle->color }}"
                                    data-vehicle-fuel="{{ $vehicle->fuel }}"
                                    data-vehicle-transmission="{{ $vehicle->transmission }}"
                                    data-vehicle-seats="{{ $vehicle->seats }}"
                                    data-vehicle-details="{{ $vehicle->details }}"
                                    data-vehicle-status="{{ $vehicle->status }}">
                                <i class="fas fa-eye me-1"></i> View
                            </button>
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if($vehicle->status !== 'approved')
                                <form action="{{ route('admin.vehicle.approve', $vehicle->id) }}" method="POST" class="approve-form">
                                    @csrf
                                    <button type="button" class="btn btn-sm approve-btn 
        {{ $vehicle->status === 'approved' ? 'btn-approved' : 
           ($vehicle->status === 'rejected' ? 'btn-rejected' : 'btn-success') }}" 
        data-vehicle-id="{{ $vehicle->id }}">
    <i class="fas fa-check me-1"></i>
    {{ $vehicle->status === 'approved' ? 'Approved' : 
       ($vehicle->status === 'rejected' ? 'Rejected' : 'Approve') }}
</button>

                                </form>
                                @endif
                                
                                @if($vehicle->status !== 'rejected')
                                <form action="{{ route('admin.vehicle.reject', $vehicle->id) }}" method="POST" class="reject-form">
                                    @csrf
                                    <button type="button" class="btn btn-sm reject-btn 
                                        {{ $vehicle->status === 'rejected' ? 'btn-rejected' : 'btn-outline-danger' }}" 
                                        data-vehicle-id="{{ $vehicle->id }}">
                                        <i class="fas fa-times me-1"></i> Reject
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.vehicle.delete', $vehicle->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>Delete
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
        <nav>
            {{ $vehicles->links() }}
        </nav>
    </div>
</div>

<!-- Vehicle Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vehicle Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="vehicleDetailsContent">
                <div class="row">
                    <div class="col-md-6">
                        <img id="detailImage" class="vehicle-details-img" alt="Vehicle">
                        
                        <div class="d-flex mt-3">
                            <div class="vehicle-detail-badge me-2">
                                <i class="fas fa-gas-pump me-1"></i> <span id="detailFuel"></span>
                            </div>
                            <div class="vehicle-detail-badge me-2">
                                <i class="fas fa-tachometer-alt me-1"></i> <span id="detailMileage"></span>
                            </div>
                            <div class="vehicle-detail-badge">
                                <i class="fas fa-calendar-alt me-1"></i> <span id="detailYear"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 id="detailName"></h3>
                        <div class="d-flex align-items-center mb-3">
                            <span id="detailStatus" class="badge me-2"></span>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p id="detailDetails"></p>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <h5>Ethical Price</h5>
                                <p class="fs-4 text-success" id="detailPrice"></p>
                            </div>
                            <div class="col-6">
                                <h5>Transmission</h5>
                                <p id="detailTransmission"></p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h5>Key Features</h5>
                            <div class="d-flex flex-wrap">
                                <div class="feature-badge">
                                    <i class="fas fa-car me-1"></i> <span id="detailBrand"></span>
                                </div>
                                <div class="feature-badge">
                                    <i class="fas fa-car me-1"></i> <span id="detailModel"></span>
                                </div>
                                <div class="feature-badge">
                                    <i class="fas fa-paint-brush me-1"></i> <span id="detailColor"></span>
                                </div>
                                <div class="feature-badge">
                                    <i class="fas fa-chair me-1"></i> <span id="detailSeats"></span> Seats
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View details functionality
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('detailImage').src = this.getAttribute('data-vehicle-image');
                document.getElementById('detailName').textContent = this.getAttribute('data-vehicle-name');
                document.getElementById('detailPrice').textContent = 'Rs' + parseInt(this.getAttribute('data-vehicle-price')).toLocaleString();
                document.getElementById('detailYear').textContent = this.getAttribute('data-vehicle-year');
                document.getElementById('detailBrand').textContent = this.getAttribute('data-vehicle-brand');
                document.getElementById('detailModel').textContent = this.getAttribute('data-vehicle-model');
                document.getElementById('detailMileage').textContent = parseInt(this.getAttribute('data-vehicle-mileage')).toLocaleString() + ' miles';
                document.getElementById('detailColor').textContent = this.getAttribute('data-vehicle-color');
                document.getElementById('detailFuel').textContent = this.getAttribute('data-vehicle-fuel');
                document.getElementById('detailTransmission').textContent = this.getAttribute('data-vehicle-transmission');
                document.getElementById('detailSeats').textContent = this.getAttribute('data-vehicle-seats');
                document.getElementById('detailDetails').textContent = this.getAttribute('data-vehicle-details');
                
                // Status badge
                const status = this.getAttribute('data-vehicle-status');
                const statusBadge = document.getElementById('detailStatus');
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                
                // Set badge color based on status
                statusBadge.className = 'badge me-2 ';
                if (status === 'approved') {
                    statusBadge.classList.add('bg-success');
                } else if (status === 'pending') {
                    statusBadge.classList.add('bg-warning');
                } else {
                    statusBadge.classList.add('bg-danger');
                }
            });
        });

        // Approve functionality
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to approve this vehicle?')) {
                    const vehicleId = this.getAttribute('data-vehicle-id');
                    const form = this.closest('.approve-form');
                    const row = this.closest('tr');
                    
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Update approve button
                            this.classList.remove('btn-pending', 'btn-rejected');
                            this.classList.add('btn-approved');
                            this.innerHTML = '<i class="fas fa-check me-1"></i> Approved';
                            
                            // Update reject button if exists
                            const rejectBtn = row.querySelector('.reject-btn');
                            if (rejectBtn) {
                                rejectBtn.classList.remove('btn-rejected');
                                rejectBtn.classList.add('btn-outline-danger');
                            }
                            
                            // Show success message
                            alert('Vehicle approved successfully!');
                            
                            // Update the modal status if open
                            const modalStatus = document.querySelector('#detailStatus');
                            if (modalStatus && modalStatus.textContent.toLowerCase() === 'pending') {
                                modalStatus.textContent = 'Approved';
                                modalStatus.className = 'badge me-2 bg-success';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while approving the vehicle.');
                    });
                }
            });
        });

        // Reject functionality
        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to reject this vehicle?')) {
                    const vehicleId = this.getAttribute('data-vehicle-id');
                    const form = this.closest('.reject-form');
                    const row = this.closest('tr');
                    
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Update reject button
                            this.classList.remove('btn-outline-danger');
                            this.classList.add('btn-rejected');
                            
                            // Update approve button
                            const approveBtn = row.querySelector('.approve-btn');
                            if (approveBtn) {
                                approveBtn.classList.remove('btn-approved', 'btn-pending');
                                approveBtn.classList.add('btn-rejected');
                                approveBtn.innerHTML = '<i class="fas fa-times me-1"></i> Rejected';
                            }
                            
                            // Show success message
                            alert('Vehicle rejected successfully!');
                            
                            // Update the modal status if open
                            const modalStatus = document.querySelector('#detailStatus');
                            if (modalStatus && (modalStatus.textContent.toLowerCase() === 'pending' || 
                                                modalStatus.textContent.toLowerCase() === 'approved')) {
                                modalStatus.textContent = 'Rejected';
                                modalStatus.className = 'badge me-2 bg-danger';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while rejecting the vehicle.');
                    });
                }
            });
        });

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if(text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection