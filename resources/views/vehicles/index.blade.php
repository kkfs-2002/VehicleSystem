@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Motors | Inventory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1e40af;
        --secondary: #64748b;
        --dark: #1e293b;
        --light: #f8fafc;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --border-radius: 10px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --transition: all 0.2s ease;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f1f5f9;
        color: var(--dark);
    }
    
    .dashboard-header {
        background: linear-gradient(to right, var(--primary), var(--primary-dark));
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
    }
    
    .stat-card {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(5px);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        transition: var(--transition);
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    /* Enhanced Vehicle Card Design */
    .vehicle-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .vehicle-media {
        height: 180px;
        position: relative;
        overflow: hidden;
    }
    
    .vehicle-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .vehicle-card:hover .vehicle-image {
        transform: scale(1.03);
    }
    
    .vehicle-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: white;
        color: var(--dark);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: var(--shadow-sm);
    }
    
    .status-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }
    
    .vehicle-content {
        padding: 1.25rem;
        flex-grow: 1;
    }
    
    .vehicle-header {
        margin-bottom: 0.75rem;
    }
    
    .vehicle-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--dark);
    }
    
    .vehicle-subtitle {
        font-size: 0.875rem;
        color: var(--secondary);
        margin-bottom: 0.5rem;
    }
    
    .vehicle-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
    }
    
    .vehicle-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
    }
    
    .detail-icon {
        margin-right: 0.5rem;
        color: var(--primary);
    }
    
    .detail-label {
        font-size: 0.75rem;
        color: var(--secondary);
    }
    
    .detail-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .vehicle-actions {
        padding: 1rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Empty State */
    .empty-state {
        background: white;
        border-radius: var(--border-radius);
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
    }
    
    /* Floating Action Button */
    .fab {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        z-index: 100;
    }
    
    .fab:hover {
        background: var(--primary-dark);
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        color: white;
    }
    
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 2rem 0;
        }
        
        .vehicle-details {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>

<!-- Dashboard Header -->
<div class="dashboard-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-3">Vehicle Inventory</h1>
                <p class="mb-0 opacity-90">Manage your vehicle collection efficiently</p>
            </div>
            <div class="col-md-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-card text-center">
                            <div class="h4 mb-1">{{ $approvedVehicles->count() }}</div>
                            <div class="small text-uppercase opacity-80">Available</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card text-center">
                            <div class="h4 mb-1">{{ $pendingVehicles->count() }}</div>
                            <div class="small text-uppercase opacity-80">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Available Vehicles Section -->
    <div class="mb-5">
        <div class="section-header">
            <h2 class="h4 fw-bold mb-0">Available Vehicles</h2>
            <span class="badge bg-primary rounded-pill">{{ $approvedVehicles->count() }}</span>
        </div>
        
        @if($approvedVehicles->count() > 0)
        <div class="row g-4">
            @foreach($approvedVehicles as $vehicle)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="vehicle-card">
                    <div class="vehicle-media">
                        <img src="{{ asset('storage/' . $vehicle->image) }}" class="vehicle-image" alt="{{ $vehicle->name }}">
                        <span class="vehicle-badge">Rs. {{ number_format($vehicle->price, 0) }}</span>
                        <span class="status-badge bg-success">Available</span>
                    </div>
                    
                    <div class="vehicle-content">
                        <div class="vehicle-header">
                            <h3 class="vehicle-title">{{ $vehicle->name }}</h3>
                            <div class="vehicle-subtitle">{{ $vehicle->brand }} • {{ $vehicle->model }}</div>
                            <div class="vehicle-price">Rs. {{ number_format($vehicle->price, 0) }}</div>
                        </div>
                        
                        <div class="vehicle-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar-check detail-icon"></i>
                                <div>
                                    <div class="detail-label">Year</div>
                                    <div class="detail-value">{{ $vehicle->year }}</div>
                                </div>
                            </div>
                            
                            @if($vehicle->mileage)
                            <div class="detail-item">
                                <i class="bi bi-speedometer2 detail-icon"></i>
                                <div>
                                    <div class="detail-label">Mileage</div>
                                    <div class="detail-value">{{ number_format($vehicle->mileage) }} km</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($vehicle->fuel)
                            <div class="detail-item">
                                <i class="bi bi-fuel-pump detail-icon"></i>
                                <div>
                                    <div class="detail-label">Fuel</div>
                                    <div class="detail-value">{{ ucfirst($vehicle->fuel) }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($vehicle->transmission)
                            <div class="detail-item">
                                <i class="bi bi-gear detail-icon"></i>
                                <div>
                                    <div class="detail-label">Transmission</div>
                                    <div class="detail-value">{{ ucfirst($vehicle->transmission) }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($vehicle->engine_capacity)
                            <div class="detail-item">
                                <i class="bi bi-turbocharger detail-icon"></i>
                                <div>
                                    <div class="detail-label">Engine</div>
                                    <div class="detail-value">{{ $vehicle->engine_capacity }}L</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($vehicle->color)
                            <div class="detail-item">
                                <i class="bi bi-palette detail-icon"></i>
                                <div>
                                    <div class="detail-label">Color</div>
                                    <div class="detail-value">{{ $vehicle->color }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="vehicle-actions">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-car-front text-muted mb-3" style="font-size: 3rem;"></i>
            <h3 class="h5 mb-2">No Vehicles Available</h3>
            <p class="text-muted mb-3">There are currently no approved vehicles in the inventory.</p>
            @auth
            <a href="{{ url('vehicles/create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Vehicle
            </a>
            @endauth
        </div>
        @endif
    </div>

  
    @auth
    @if($pendingVehicles->count() > 0)
    <div class="mb-5">
        <div class="section-header">
            <h2 class="h4 fw-bold mb-0">Pending Approval</h2>
            <span class="badge bg-warning rounded-pill">{{ $pendingVehicles->count() }}</span>
        </div>
        
        <div class="row g-4">
            @foreach($pendingVehicles as $vehicle)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="vehicle-card">
                    <div class="vehicle-media">
                        <img src="{{ asset('storage/' . $vehicle->image) }}" class="vehicle-image" alt="{{ $vehicle->name }}">
                        <span class="vehicle-badge">Rs. {{ number_format($vehicle->price, 0) }}</span>
                        <span class="status-badge bg-warning">Pending</span>
                    </div>
                    
                    <div class="vehicle-content">
                        <div class="vehicle-header">
                            <h3 class="vehicle-title">{{ $vehicle->name }}</h3>
                            <div class="vehicle-subtitle">{{ $vehicle->brand }} • {{ $vehicle->model }}</div>
                            <div class="vehicle-price">Rs. {{ number_format($vehicle->price, 0) }}</div>
                        </div>
                        
                        <div class="vehicle-details">
                            <div class="detail-item">
                                <i class="bi bi-calendar-check detail-icon"></i>
                                <div>
                                    <div class="detail-label">Year</div>
                                    <div class="detail-value">{{ $vehicle->year }}</div>
                                </div>
                            </div>
                            
                            @if($vehicle->mileage)
                            <div class="detail-item">
                                <i class="bi bi-speedometer2 detail-icon"></i>
                                <div>
                                    <div class="detail-label">Mileage</div>
                                    <div class="detail-value">{{ number_format($vehicle->mileage) }} km</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($vehicle->fuel)
                            <div class="detail-item">
                                <i class="bi bi-fuel-pump detail-icon"></i>
                                <div>
                                    <div class="detail-label">Fuel</div>
                                    <div class="detail-value">{{ ucfirst($vehicle->fuel) }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($vehicle->engine_capacity)
                            <div class="detail-item">
                                <i class="bi bi-turbocharger detail-icon"></i>
                                <div>
                                    <div class="detail-label">Engine</div>
                                    <div class="detail-value">{{ $vehicle->engine_capacity }}L</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="vehicle-actions">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                           
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endauth
</div>

@auth

<a href="{{ url('vehicles/create') }}" class="fab" title="Add New Vehicle">
    <i class="bi bi-plus-lg"></i>
</a>
@endauth

<script>

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.vehicle-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.4s ease ' + (index * 0.1) + 's';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    });
});
</script>

@endsection