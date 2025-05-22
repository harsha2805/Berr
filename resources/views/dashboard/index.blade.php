@extends('layouts.dashboard.app')

@section('title', 'DASHBOARD')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Welcome, {{ Auth::user()->name ?? '' }}</h2>
        <p class="text-muted mb-0">Here’s your account overview.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row row-cols-1 gy-4">
                <!-- Email -->
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle text-primary rounded-circle d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-envelope-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Email</div>
                            <div class="text-muted">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-subtle text-success rounded-circle d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-phone-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Mobile Number</div>
                            <div class="text-muted">{{ Auth::user()->mobile_number }}</div>
                        </div>
                    </div>
                </div>

                <!-- Email Verified -->
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-subtle text-info rounded-circle d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Email Verified</div>
                            @if(Auth::user()->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Not Verified</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile Verified -->
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle text-warning rounded-circle d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Mobile Verified</div>
                            @if(Auth::user()->mobile_number_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Not Verified</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-12">
                    <div class="d-flex align-items-start">
                        <div class="bg-secondary-subtle text-secondary rounded-circle d-flex justify-content-center align-items-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold mb-1">Address</div>
                            @if(Auth::user()->address)
                                <div class="text-muted">{{ Auth::user()->address }}</div>
                                <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#addressModal" title="Edit Address">
                                    <i class="bi bi-pencil-fill me-1"></i> Edit Address
                                </button>
                            @else
                                <div class="text-muted fst-italic">No address added yet.</div>
                                <button class="btn btn-sm btn-outline-secondary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#addressModal" title="Add Address">
                                    <i class="bi bi-plus-circle me-1"></i> Add Address
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.add-address')
@endsection