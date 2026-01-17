@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="user-dashboard">

    <div class="row dashboard-row">

        {{-- FILTER --}}
        <div class="col-lg-3 filter-col">
            <div class="card filter-card sticky-top">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-center">
                    <h5 class="card-title mb-0 text-center">
                        <i class="bi bi-funnel me-2"></i> Filter
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('user.dashboard') }}">
                        {{-- isi filter --}}

                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary btn-sm fw-bold">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- LIST KOS --}}
        <div class="col-lg-9 content-col d-flex flex-wrap justify-content-center">
            @forelse($properties as $p)
                <div class="property-wrapper">
                    <div class="card property-card h-100">
                        <img
                            src="{{ optional($p->images->first())->file_path ? asset('storage/'.$p->images->first()->file_path) : 'https://placehold.co/600x400' }}"
                            class="card-img-top"
                        >
                        <div class="card-body d-flex flex-column">
                            <small class="text-muted">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $p->district ?? $p->city }}
                            </small>

                            <h6 class="fw-bold mt-2">{{ $p->name }}</h6>

                            <div class="price mt-auto">
                                Rp {{ number_format($p->price,0,',','.') }}/bulan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    Tidak ada kos ditemukan
                </div>
            @endforelse
        </div>

    </div>
</div>

</div>
<style>
:root {
    --bs-primary: #BCCCDC !important;
    --bs-success: #2F6F73 !important;
}
/* ===================== USER DASHBOARD ===================== */
.user-dashboard {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1rem 4rem;
    background-color: var(--kosan-bg-section);
}

/* ===================== ROW ===================== */
.dashboard-row {
    display: flex;
    gap: 2rem;
    justify-content: center;
}

/* ===================== FILTER ===================== */
.filter-col {
    max-width: 280px;
}

.filter-card {
    background: var(--kosan-card-bg);
    border: 1px solid var(--kosan-border);
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    padding: 0;
}

.filter-card .card-header {
    border-bottom: 1px solid var(--kosan-border);
}

.filter-card .card-title {
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;  /* biar icon + teks rata tengah */
    gap: 0.5rem;
}

/* ===================== PROPERTY LIST ===================== */
.content-col {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* biar semua card di tengah */
    gap: 1.5rem;
}

.property-wrapper {
    max-width: 350px;
}

/* ===================== PROPERTY CARD ===================== */
.property-card {
    border-radius: 18px;
    overflow: hidden;
    background: var(--kosan-card-bg);
    border: 1px solid var(--kosan-border);
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.property-card:hover {
    transform: translateY(-6px);
    border-color: var(--kosan-secondary);
    box-shadow: 0 14px 40px rgba(0,0,0,0.15);
}

.property-card img {
    height: 200px;
    object-fit: cover;
}

/* ===================== PRICE ===================== */
.property-card .price {
    color: var(--kosan-secondary);
    font-weight: 800;
    margin-top: 1rem;
    padding-top: 0.75rem;
    border-top: 1px solid rgba(188,204,220,0.3);
}

/* ===================== RESPONSIVE ===================== */
@media (max-width: 992px) {
    .dashboard-row {
        flex-direction: column;
        gap: 2rem;
    }

    .filter-col {
        max-width: 100%;
        margin: 0 auto;
    }

    .content-col {
        justify-content: center;
    }
}
</style>
@endsection
