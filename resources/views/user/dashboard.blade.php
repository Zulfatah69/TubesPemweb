@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-slate-sm sticky-top" style="top: 100px; border-radius: 20px; z-index: 10;">
                <div class="card-header bg-white border-bottom border-slate-100 py-3">
                    <h6 class="card-title mb-0 fw-bold text-slate-800">
                        <i class="bi bi-sliders2-vertical me-2"></i>Filter Pencarian
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('user.dashboard') }}" id="filterForm">
                        
                        {{-- LOKASI DENGAN API INDONESIA --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider">Wilayah</label>
                            <select id="provinsi" name="province" class="form-select form-select-sm mb-2 rounded-3 border-slate-200 shadow-none" data-old="{{ request('province') }}">
                                <option value="">Pilih Provinsi</option>
                            </select>
                            <select id="kota" name="city" class="form-select form-select-sm mb-2 rounded-3 border-slate-200 shadow-none" data-old="{{ request('city') }}">
                                <option value="">Pilih Kota/Kab</option>
                            </select>
                            <select id="kecamatan" name="district" class="form-select form-select-sm rounded-3 border-slate-200 shadow-none" data-old="{{ request('district') }}">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>

                        <hr class="my-4 border-slate-100">

                        {{-- HARGA --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider">Budget Maksimal</label>
                            <select name="max_price" class="form-select form-select-sm rounded-3 border-slate-200 shadow-none">
                                <option value="">Semua Harga</option>
                                <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>Rp 500rb</option>
                                <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>Rp 1 Juta</option>
                                <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>Rp 2 Juta</option>
                                <option value="3000000" {{ request('max_price') == '3000000' ? 'selected' : '' }}>Rp 3 Juta</option>
                            </select>
                        </div>

                        <hr class="my-4 border-slate-100">

                        {{-- FASILITAS --}}
                        <div class="mb-4">
                            <label class="form-label x-small text-slate-400 fw-bold text-uppercase tracking-wider mb-3">Fasilitas Utama</label>
                            @php
                                $facilities = ['WiFi','AC','Kamar mandi dalam','Dapur','Kasur'];
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
                            <button type="submit" class="btn btn-slate-800 btn-sm fw-bold py-2 rounded-pill shadow-slate-sm">Terapkan</button>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-link btn-sm text-slate-400 text-decoration-none">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- LIST KOS --}}
        <div class="col-lg-9">
            <h4 class="fw-bold text-slate-800 mb-4 px-2">Rekomendasi Kos</h4>

            <div class="row g-4">
                @forelse($properties as $p)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-slate-sm action-card overflow-hidden" style="border-radius: 20px;">
                        {{-- IMAGE --}}
                        <div class="position-relative" style="height: 200px;">
                            @php $img = $p->images->first(); @endphp
                            <img src="{{ $img ? asset('storage/'.$img->file_path) : 'https://placehold.co/600x400?text=No+Image' }}"
                                 class="w-100 h-100 object-fit-cover transition-transform">
                            
                            <div class="position-absolute bottom-0 start-0 p-3 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.6))">
                                <span class="badge bg-white text-slate-800 rounded-pill x-small fw-bold px-2 py-1">
                                    {{ strtoupper($p->gender_type ?? 'Campuran') }}
                                </span>
                            </div>
                        </div>

                        {{-- BODY --}}
                        <div class="card-body p-3">
                            <div class="x-small text-slate-400 fw-bold text-uppercase mb-1">
                                <i class="bi bi-geo-alt me-1"></i> {{ $p->district ?? $p->city }}
                            </div>

                            <h6 class="fw-bold text-slate-800 text-truncate mb-2">
                                <a href="{{ route('user.property.show', $p->id) }}" class="text-decoration-none text-slate-800 stretched-link">
                                    {{ $p->name }}
                                </a>
                            </h6>

                            <div class="d-flex align-items-baseline gap-1 mt-auto">
                                <span class="text-slate-800 fw-bold fs-5">Rp{{ number_format($p->price/1000, 0) }}rb</span>
                                <span class="text-slate-400 x-small">/ bln</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-slate-400 fw-medium">Tidak ada kos yang sesuai dengan filter Anda.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- JAVASCRIPT UNTUK API WILAYAH --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provSelect = document.getElementById('provinsi');
    const citySelect = document.getElementById('kota');
    const distSelect = document.getElementById('kecamatan');

    // Load Provinsi
    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
        .then(response => response.json())
        .then(provinces => {
            let options = '<option value="">Pilih Provinsi</option>';
            provinces.forEach(p => {
                const selected = p.name === provSelect.dataset.old ? 'selected' : '';
                options += `<option value="${p.name}" data-id="${p.id}" ${selected}>${p.name}</option>`;
            });
            provSelect.innerHTML = options;
            if(provSelect.dataset.old) provSelect.dispatchEvent(new Event('change'));
        });

    // Change Provinsi -> Load Kota
    provSelect.addEventListener('change', function() {
        const provId = this.options[this.selectedIndex].getAttribute('data-id');
        if (!provId) return;

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
            .then(response => response.json())
            .then(regencies => {
                let options = '<option value="">Pilih Kota/Kab</option>';
                regencies.forEach(r => {
                    const selected = r.name === citySelect.dataset.old ? 'selected' : '';
                    options += `<option value="${r.name}" data-id="${r.id}" ${selected}>${r.name}</option>`;
                });
                citySelect.innerHTML = options;
                if(citySelect.dataset.old) citySelect.dispatchEvent(new Event('change'));
            });
    });

    // Change Kota -> Load Kecamatan
    citySelect.addEventListener('change', function() {
        const cityId = this.options[this.selectedIndex].getAttribute('data-id');
        if (!cityId) return;

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`)
            .then(response => response.json())
            .then(districts => {
                let options = '<option value="">Pilih Kecamatan</option>';
                districts.forEach(d => {
                    const selected = d.name === distSelect.dataset.old ? 'selected' : '';
                    options += `<option value="${d.name}" ${selected}>${d.name}</option>`;
                });
                distSelect.innerHTML = options;
            });
    });
});
</script>

<style>
    :root {
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-800: #1e293b;
    }
    .x-small { font-size: 0.72rem; }
    .text-slate-400 { color: var(--slate-400); }
    .text-slate-800 { color: var(--slate-800); }
    .border-slate-100 { border-color: var(--slate-100) !important; }
    .border-slate-200 { border-color: var(--slate-200) !important; }
    .btn-slate-800 { background: var(--slate-800); color: white; border: none; }
    .btn-slate-800:hover { background: #0f172a; color: white; }
    .shadow-slate-sm { box-shadow: 0 4px 12px rgba(30, 41, 59, 0.08); }
    .action-card { transition: transform 0.3s ease; }
    .action-card:hover { transform: translateY(-5px); }
    .custom-check .form-check-input:checked { background-color: var(--slate-800); border-color: var(--slate-800); }
</style>
@endsection