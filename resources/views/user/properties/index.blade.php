@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px; border-radius: 20px; z-index: 10;">
                <div class="card-header bg-white border-bottom border-slate-100 py-3">
                    <h6 class="card-title mb-0 fw-bold text-slate-800">
                        <i class="bi bi-sliders2-vertical me-2"></i>Filter Pencarian
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('user.dashboard') }}">
                        
                        {{-- LOKASI --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider">Lokasi Wilayah</label>
                            <select id="provinsi" name="province" class="form-select form-select-sm mb-2 rounded-3 border-slate-200"></select>
                            <select id="kota" name="city" class="form-select form-select-sm mb-2 rounded-3 border-slate-200"></select>
                            <select id="kecamatan" name="district" class="form-select form-select-sm rounded-3 border-slate-200"></select>
                        </div>

                        <hr class="my-4 border-slate-100">

                        {{-- HARGA --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider">Budget Maksimal</label>
                            <select name="max_price" class="form-select form-select-sm rounded-3 border-slate-200">
                                <option value="">Semua Harga</option>
                                <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>Rp 500rb</option>
                                <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>Rp 1 Juta</option>
                                <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>Rp 2 Juta</option>
                                <option value="3000000" {{ request('max_price') == '3000000' ? 'selected' : '' }}>Rp 3 Juta</option>
                            </select>
                        </div>

                        <hr class="my-4 border-slate-100">

                        {{-- KATEGORI KOS --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider">Tipe Kos</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach(['putra', 'putri', 'campuran'] as $g)
                                <div class="form-check custom-check">
                                    <input class="form-check-input shadow-none border-slate-300" type="radio" name="gender_type" value="{{ $g }}" id="g-{{ $g }}" {{ request('gender_type') == $g ? 'checked' : '' }}>
                                    <label class="form-check-label small text-slate-600" for="g-{{ $g }}">Kos {{ ucfirst($g) }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <hr class="my-4 border-slate-100">

                        {{-- FASILITAS --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider mb-3">Fasilitas Utama</label>
                            @php
                                $facilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar'];
                                $selectedFacilities = request('facility', []);
                            @endphp
                            
                            <div class="d-flex flex-column gap-2">
                                @foreach($facilities as $f)
                                    <div class="form-check custom-check">
                                        <input class="form-check-input shadow-none border-slate-300" type="checkbox" name="facility[]" value="{{ $f }}"
                                            {{ in_array($f, $selectedFacilities) ? 'checked' : '' }} id="f-{{ $loop->index }}">
                                        <label class="form-check-label small text-slate-600" for="f-{{ $loop->index }}">{{ $f }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-slate-800 btn-sm fw-bold py-2 rounded-pill shadow-slate">Terapkan Filter</button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-link btn-sm text-slate-400 text-decoration-none">Reset Semua</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- LIST KOS --}}
        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
                <div>
                    <h4 class="fw-bold text-slate-800 mb-1">Pilihan Kos Terbaik</h4>
                    <p class="text-slate-500 small mb-0">Menampilkan {{ count($properties) }} properti tersedia saat ini.</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse($properties as $p)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm action-card overflow-hidden" style="border-radius: 20px;">

                        {{-- IMAGE --}}
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            <a href="{{ route('user.property.show', $p->id) }}">
                                @php $img = $p->images->first(); @endphp
                                <img src="{{ $img ? asset($img->file_path) : 'https://placehold.co/600x400?text=No+Image' }}"
                                     class="w-100 h-100 object-fit-cover transition-transform">
                            </a>

                            {{-- BADGE GENDER --}}
                            <div class="position-absolute top-0 start-0 p-3">
                                @php
                                    $genderStyles = match($p->gender_type){
                                        'putra' => 'bg-slate-800 text-white',
                                        'putri' => 'bg-rose-500 text-white',
                                        'campuran' => 'bg-emerald-500 text-white',
                                        default => 'bg-slate-200'
                                    };
                                @endphp
                                <span class="badge {{ $genderStyles }} border-0 px-3 py-2 rounded-pill shadow-sm x-small fw-bold">
                                    {{ strtoupper($p->gender_type) }}
                                </span>
                            </div>
                        </div>

                        {{-- BODY --}}
                        <div class="card-body p-4">
                            <div class="x-small text-slate-400 fw-bold text-uppercase mb-2 tracking-widest">
                                <i class="bi bi-geo-alt me-1"></i> {{ $p->district ?? $p->city }}
                            </div>

                            <h5 class="fw-bold mb-3">
                                <a href="{{ route('user.property.show', $p->id) }}" class="text-slate-800 text-decoration-none stretched-link">
                                    {{ $p->name }}
                                </a>
                            </h5>

                            <div class="d-flex align-items-end gap-1 mb-3 border-top border-slate-50 pt-3">
                                <span class="text-slate-800 fw-bold h4 mb-0">
                                    Rp{{ number_format($p->price/1000, 0) }}rb
                                </span>
                                <span class="text-slate-400 small mb-1">/ bulan</span>
                            </div>

                            <div class="d-flex flex-wrap gap-1">
                                @foreach(array_slice($p->facilities ?? [], 0, 2) as $fac)
                                    <span class="badge bg-slate-50 text-slate-500 border-0 fw-medium p-2">{{ $fac }}</span>
                                @endforeach
                                @if(count($p->facilities ?? []) > 2)
                                    <span class="badge bg-white text-slate-300 border-0 fw-medium p-2">+{{ count($p->facilities) - 2 }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3 text-slate-200">
                        <i class="bi bi-search" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold text-slate-800">Tidak ada kos ditemukan</h5>
                    <p class="text-slate-500">Coba ubah filter lokasi atau harga Anda.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-600: #475569;
        --slate-800: #1e293b;
        --rose-500: #f43f5e;
        --emerald-500: #10b981;
    }

    body { background-color: #fcfcfd; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-400 { color: var(--slate-400); }
    .bg-slate-50 { background-color: var(--slate-50); }
    .bg-slate-800 { background-color: var(--slate-800); }
    .bg-rose-500 { background-color: var(--rose-500); }
    .bg-emerald-500 { background-color: var(--emerald-500); }
    .border-slate-100 { border-color: var(--slate-100) !important; }

    .x-small { font-size: 0.7rem; }
    .tracking-widest { letter-spacing: 0.1em; }

    .btn-slate-800 { background: var(--slate-800); color: white; border: none; }
    .btn-slate-800:hover { background: #0f172a; color: white; transform: translateY(-1px); }
    .shadow-slate { box-shadow: 0 4px 6px -1px rgba(30, 41, 59, 0.2); }

    .action-card {
        transition: all 0.3s ease;
        border: 1px solid transparent !important;
    }
    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05) !important;
        border-color: var(--slate-100) !important;
    }
    .action-card:hover .transition-transform {
        transform: scale(1.1);
    }
    .transition-transform { transition: transform 0.6s ease; }

    .custom-check .form-check-input:checked {
        background-color: var(--slate-800);
        border-color: var(--slate-800);
    }

    .object-fit-cover { object-fit: cover; }
</style>
@endsection