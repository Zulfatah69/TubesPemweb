@extends('layouts.app')

@section('content')
<<<<<<< HEAD

<h4>Cari Kos</h4>

@include('user.search-form') {{-- filter yang sudah kamu buat --}}

@include('user.property-list') {{-- daftar kos --}}
=======
<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 90px; z-index: 100;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-funnel"></i> Filter</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('user.dashboard') }}">

                    {{-- LOKASI --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold text-uppercase">Lokasi</label>
                        <select id="provinsi" name="province" class="form-select form-select-sm mb-2">
                            <option value="">Memuat provinsi...</option>
                        </select>
                        <select id="kota" name="city" class="form-select form-select-sm mb-2">
                            <option value="">Pilih provinsi dulu</option>
                        </select>
                        <select id="kecamatan" name="district" class="form-select form-select-sm">
                            <option value="">Pilih kota dulu</option>
                        </select>
                    </div>

                    <hr class="text-muted opacity-25">

                    {{-- HARGA --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold text-uppercase">Harga Maksimal</label>
                        <select name="max_price" class="form-select form-select-sm">
                            <option value="">Semua Harga</option>
                            <option value="500000" {{ request('max_price')=='500000'?'selected':'' }}>Rp 500rb</option>
                            <option value="1000000" {{ request('max_price')=='1000000'?'selected':'' }}>Rp 1 Juta</option>
                            <option value="2000000" {{ request('max_price')=='2000000'?'selected':'' }}>Rp 2 Juta</option>
                            <option value="3000000" {{ request('max_price')=='3000000'?'selected':'' }}>Rp 3 Juta</option>
                        </select>
                    </div>

                    <hr class="text-muted opacity-25">

                    {{-- FASILITAS --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold text-uppercase mb-2">Fasilitas</label>
                        @php
                            $facilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar'];
                            $selectedFacilities = request('facility', []);
                        @endphp
                        @foreach($facilities as $f)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facility[]" value="{{ $f }}"
                                    {{ in_array($f,$selectedFacilities)?'checked':'' }}>
                                <label class="form-check-label small">{{ $f }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm fw-bold">Terapkan Filter</button>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- LIST KOS --}}
    <div class="col-lg-9">
        <h4 class="fw-bold mb-3">Rekomendasi Kos</h4>

        <div class="row g-4">
            @forelse($properties as $p)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ optional($p->images->first())->file_path
                            ? asset('storage/'.$p->images->first()->file_path)
                            : 'https://placehold.co/600x400' }}"
                            class="card-img-top" style="height:200px;object-fit:cover">

                        <div class="card-body">
                            <small class="text-muted">
                                <i class="bi bi-geo-alt"></i>
                                {{ $p->district ?? $p->city }}
                            </small>
                            <h6 class="fw-bold mt-1">{{ $p->name }}</h6>
                            <div class="text-primary fw-bold">
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

{{-- LOKASI --}}
<div class="mb-3">
    <label class="form-label small text-muted fw-bold text-uppercase">Lokasi</label>

    <select id="provinsi"
            name="province"
            class="form-select form-select-sm mb-2"
            data-old="{{ request('province') }}">
    </select>

    <select id="kota"
            name="city"
            class="form-select form-select-sm mb-2"
            data-old="{{ request('city') }}">
    </select>

    <select id="kecamatan"
            name="district"
            class="form-select form-select-sm"
            data-old="{{ request('district') }}">
    </select>
</div>
>>>>>>> zulfatah

@endsection
