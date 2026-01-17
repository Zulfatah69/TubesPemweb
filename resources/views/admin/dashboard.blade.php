@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
    }

    /* Override Tombol Biru ke Slate */
    .btn-slate-dark { 
        background-color: var(--slate-800); 
        color: white; 
        border: none; 
        transition: 0.3s; 
        font-weight: 500;
        border-radius: 8px;
    }
    .btn-slate-dark:hover { 
        background-color: var(--slate-900); 
        color: white; 
    }
    .btn-outline-slate { 
        color: var(--slate-800); 
        border: 1px solid var(--slate-800); 
        font-weight: 500;
        border-radius: 8px;
    }
    .btn-outline-slate:hover { 
        background-color: var(--slate-50); 
        color: var(--slate-800);
    }

    /* Ikon dan Box Styling */
    .icon-box-slate { 
        background-color: rgba(30, 41, 59, 0.1); 
        color: var(--slate-800) !important; 
        border-radius: 12px;
        padding: 1rem;
    }
    
    /* Border samping kartu yang tadinya warna-warni jadi Slate seragam */
    .border-slate-theme { 
        border-left: 5px solid var(--slate-800) !important; 
    }
</style>

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Dashboard Admin</h4>
            <p class="text-muted small mb-0">Ringkasan statistik aplikasi KosConnect.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-slate btn-sm">
                <i class="bi bi-people me-1"></i> Users & Owners
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('bookingChart').getContext('2d');

        // Data dari Controller
        const labels = @json($chartLabels ?? []);
        const data = @json($chartData ?? []);

        // Membuat gradien warna Slate yang elegan
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(30, 41, 59, 0.9)');   // Slate 800
        gradient.addColorStop(1, 'rgba(30, 41, 59, 0.1)');   // Transparent Slate

        new Chart(ctx, {
            type: 'bar', // Gunakan 'bar' atau 'line'
            data: {
                labels: labels,
                datasets: [{
                    label: 'Booking Masuk',
                    data: data,
                    backgroundColor: gradient,
                    borderColor: '#1e293b',
                    borderWidth: 2,
                    borderRadius: 8, // Membuat bar membulat di atas
                    barPercentage: 0.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: { 
                            color: '#94a3b8', 
                            stepSize: 1,
                            font: { family: 'Inter, sans-serif', size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { 
                            color: '#64748b',
                            font: { weight: 'bold', size: 11 }
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush