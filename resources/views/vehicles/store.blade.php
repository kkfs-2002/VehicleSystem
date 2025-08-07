@extends('layouts.app')

@section('content')
<div class="container my-5" style="max-width: 700px;">
    <h2 class="mb-4 text-center">Add New Vehicle</h2>

    <form action="{{ url('/vehicles/store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Vehicle Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter vehicle name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (LKR)</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Enter price" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" name="year" id="year" class="form-control" placeholder="Enter year" required>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" placeholder="Enter brand" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" placeholder="Enter model" required>
        </div>

        <div class="mb-3">
            <label for="mileage" class="form-label">Mileage (km)</label>
            <input type="number" name="mileage" id="mileage" class="form-control" placeholder="Enter mileage" required>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" name="color" id="color" class="form-control" placeholder="Enter color" required>
        </div>

        <div class="mb-3">
            <label for="fuel" class="form-label">Fuel Type</label>
            <select name="fuel" id="fuel" class="form-select" required>
                <option value="" disabled selected>Select fuel type</option>
                <option value="petrol">Petrol</option>
                <option value="diesel">Diesel</option>
                <option value="electric">Electric</option>
                <option value="hybrid">Hybrid</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="transmission" class="form-label">Transmission</label>
            <select name="transmission" id="transmission" class="form-select" required>
                <option value="" disabled selected>Select transmission</option>
                <option value="automatic">Automatic</option>
                <option value="manual">Manual</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="seats" class="form-label">Seats</label>
            <input type="number" name="seats" id="seats" class="form-control" placeholder="Enter number of seats" required>
        </div>

        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea name="details" id="details" class="form-control" rows="4" placeholder="Enter vehicle details" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Vehicle Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Submit Vehicle</button>
    </form>
</div>
@endsection
