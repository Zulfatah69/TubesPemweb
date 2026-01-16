@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Dashboard Admin</h4>
            <p class="text-muted small mb-0">Ringkasan statistik aplikasi KosConnect.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-people me-1"></i> Users & Owners
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-journal-bookmark me-1"></i> Monitoring Booking
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        
        {{-- Total Users --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                                <i class="bi bi-person-fill fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted small mb-1 text-uppercase fw-bold">Total Users</p>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalUsers ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Owners --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-success bg-opacity-10 text-success rounded p-3">
                                <i class="bi bi-briefcase-fill fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted small mb-1 text-uppercase fw-bold">Total Owners</p>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalOwners ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Properties --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-info bg-opacity-10 text-info rounded p-3">
                                <i class="bi bi-building-fill fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted small mb-1 text-uppercase fw-bold">Total Kosan</p>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalProperties ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Bookings --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                                <i class="bi bi-calendar-check-fill fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted small mb-1 text-uppercase fw-bold">Total Booking</p>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalBookings ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CHART SECTION --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-bar-chart-line me-2 text-primary"></i>Statistik Booking Bulanan
                    </h6>
                    <span class="badge bg-light text-muted border">Tahun Ini</span>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Load Chart JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('bookingChart');

        const labels = @json($chartLabels ?? []);
        const data = @json($chartData ?? []);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Booking Masuk',
                    data: data,
                    backgroundColor: 'rgba(13, 110, 253, 0.7)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0' 
                        },
                        ticks: {
                            stepSize: 1 
                        }
                    },
                    x: {
                        grid: {
                            display: false 
                        }
                    }
                }
            }
        });
    });
</script>
@endpush