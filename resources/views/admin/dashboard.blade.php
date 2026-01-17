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
            <a href="{{ route('admin.users.index') }}" class="btn btn-users-owner btn-sm">
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
                            <h4 class="fw-bold mb-0 stat-number">{{ $totalUsers ?? 0 }}</h4>
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
                    <h6 class="mb-0 fw-bold statistik-title">
                        <i class="bi bi-bar-chart-line me-2 statistik-icon"></i>Statistik Booking Bulanan
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

<style>
.btn-users-owner {
    background-color: #9AA6B2;
    color: #fff;
    border: none;
}

.btn-users-owner i {
    color: #ffffff;   /* WARNA ICON */
}

.btn-users-owner:hover {
    background-color: #8C96A0;  /* ganti hover jadi abu */
    color: #fff;                 /* teks ikut abu gelap biar kontras */
}

.btn-users-owner:hover i {
    color: #fff;      /* icon ikut berubah pas hover */
}

.card .card-body h4 {
    color: #9AA6B2 !important;
}

.statistik-title {
    color: #5F666E;
}

.statistik-icon {
    color: #5F666E;
}

</style>
{{-- Load Chart JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('bookingChart');

    const labels = @json($chartLabels ?? []);
    const data = @json($chartData ?? []);

    // Ambil warna dari CSS variable
    const style = getComputedStyle(document.documentElement);
    const primaryColor = style.getPropertyValue('--bs-primary').trim() || 'rgba(121, 127, 138, 0.7)';
    const primaryBorder = style.getPropertyValue('--bs-primary').trim() || 'rgb(142, 165, 199)';
    const secondaryColor = style.getPropertyValue('--bs-secondary').trim() || '#6C757D';

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Booking Masuk',
                data: data,
                backgroundColor: primaryColor,
                borderColor: primaryBorder,
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
                    backgroundColor: secondaryColor,
                    padding: 10,
                    cornerRadius: 8,
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(188,204,220,0.3)' // warna grid konsisten dengan --kosan-border
                    },
                    ticks: {
                        stepSize: 1,
                        color: style.getPropertyValue('--kosan-text-main').trim() || '#5F666E'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: style.getPropertyValue('--kosan-text-main').trim() || '#5F666E'
                    }
                }
            }
        }
    });
});
</script>
@endpush