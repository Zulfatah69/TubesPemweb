@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-600: #475569;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
    }

    /* Override Tombol */
    .btn-slate-dark { background: var(--slate-800); color: white; border: none; transition: 0.3s; }
    .btn-slate-dark:hover { background: var(--slate-900); color: white; transform: translateY(-1px); }
    .btn-outline-slate { color: var(--slate-800); border: 1px solid var(--slate-800); transition: 0.3s; }
    .btn-outline-slate:hover { background: var(--slate-100); color: var(--slate-800); }

    /* Card Styling */
    .card-stat { border: none; border-radius: 15px; transition: 0.3s; }
    .card-stat:hover { transform: translateY(-3px); }
    .icon-box { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    
    /* Warna Ikon & Border Khusus Slate */
    .bg-slate-soft { background-color: rgba(30, 41, 59, 0.1); color: var(--slate-800); }
    .border-slate-theme { border-left: 5px solid var(--slate-800) !important; }
</style>

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-slate-800 mb-1">Dashboard Admin</h4>
            <p class="text-muted small mb-0">Ringkasan statistik aplikasi KosConnect.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-slate btn-sm px-3">
                <i class="bi bi-people me-1"></i> Users & Owners
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-slate-dark btn-sm px-3 shadow-sm">
                <i class="bi bi-journal-bookmark me-1"></i> Monitoring Booking
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['label' => 'Total Users', 'value' => $totalUsers ?? 0, 'icon' => 'bi-person-fill'],
                ['label' => 'Total Owners', 'value' => $totalOwners ?? 0, 'icon' => 'bi-briefcase-fill'],
                ['label' => 'Total Kosan', 'value' => $totalProperties ?? 0, 'icon' => 'bi-building-fill'],
                ['label' => 'Total Booking', 'value' => $totalBookings ?? 0, 'icon' => 'bi-calendar-check-fill'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-md-3">
            <div class="card card-stat shadow-sm border-slate-theme">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="icon-box bg-slate-soft">
                                <i class="{{ $stat['icon'] }} fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-slate-400 x-small mb-1 text-uppercase fw-bold tracking-wider" style="font-size: 0.7rem;">{{ $stat['label'] }}</p>
                            <h4 class="fw-bold mb-0 text-slate-800">{{ $stat['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- CHART SECTION --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h6 class="mb-0 fw-bold text-slate-800">
                        <i class="bi bi-bar-chart-line me-2"></i>Statistik Booking Bulanan
                    </h6>
                    <span class="badge bg-slate-100 text-slate-600 border-0 px-3 py-2 rounded-pill x-small">Tahun 2026</span>
                </div>
                <div class="card-body p-4">
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

        const labels = @json($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']);
        const data = @json($chartData ?? [0, 0, 0, 0, 0, 0]);

        // Gradien Slate Grey
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(30, 41, 59, 1)');   // Slate 800
        gradient.addColorStop(1, 'rgba(241, 245, 249, 0.5)'); // Slate 100

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Booking',
                    data: data,
                    backgroundColor: gradient,
                    borderColor: '#0f172a',
                    borderWidth: 1,
                    borderRadius: 6,
                    barPercentage: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f1f5f9' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { color: '#1e293b', font: { weight: '600' } }
                    }
                }
            }
        });
    });
</script>
@endpush