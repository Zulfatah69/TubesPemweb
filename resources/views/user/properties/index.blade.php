@extends('layouts.app')

@section('content')
<div class="row">

    {{-- FILTER --}}
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 90px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0" style="color: #5F666E;">
                    <i class="bi bi-funnel"></i> Filter
                </h5>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('user.dashboard') }}">

                    {{-- LOKASI --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Lokasi</label>
                        <select id="provinsi" name="province" class="form-select form-select-sm mb-2"></select>
                        <select id="kota" name="city" class="form-select form-select-sm mb-2"></select>
                        <select id="kecamatan" name="district" class="form-select form-select-sm"></select>
                    </div>

                    <hr>

                    {{-- HARGA --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Harga Maksimal</label>
                        <select name="max_price" class="form-select form-select-sm">
                            <option value="">Semua Harga</option>
                            <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>Rp 500rb</option>
                            <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>Rp 1 Juta</option>
                            <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>Rp 2 Juta</option>
                            <option value="3000000" {{ request('max_price') == '3000000' ? 'selected' : '' }}>Rp 3 Juta</option>
                        </select>
                    </div>

                    <hr>

                    {{-- KATEGORI --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Kategori Kos</label>
                        <select name="gender_type" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option value="putra" {{ request('gender_type') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('gender_type') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campuran" {{ request('gender_type') == 'campuran' ? 'selected' : '' }}>Campuran</option>
                        </select>
                    </div>

                    <hr>

                    {{-- FASILITAS --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Fasilitas</label>

                        @php
                            $facilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar'];
                            $selected = request('facility', []);
                        @endphp

                        @foreach($facilities as $f)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facility[]" value="{{ $f }}"
                                    {{ in_array($f, $selected) ? 'checked' : '' }}>
                                <label class="form-check-label small">{{ $f }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-sm fw-bold">Terapkan</button>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- LIST PROPERTI --}}
    <div class="col-lg-9">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Rekomendasi Kos</h4>
            <span class="text-muted small">Menampilkan {{ $properties->count() }} hasil</span>
        </div>

        <div class="row g-4">
            @forelse($properties as $p)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm card-hover">

                        {{-- IMAGE --}}
                        <div class="position-relative">
                            <a href="{{ route('user.property.show', $p) }}">
                                @php $img = $p->images->first(); @endphp
                                <img
                                    src="{{ $img ? asset('storage/'.$img->file_path) : 'https://placehold.co/600x400?text=No+Image' }}"
                                    class="card-img-top"
                                    style="height:200px; object-fit:cover;">
                            </a>

                            @php
                                $badge = match($p->gender_type){
                                    'putra' => 'primary',
                                    'putri' => 'danger',
                                    'campuran' => 'success',
                                    default => 'secondary'
                                };
                            @endphp

                            <span class="badge bg-{{ $badge }} position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
                                {{ ucfirst($p->gender_type) }}
                            </span>
                        </div>

                        {{-- BODY --}}
                        <div class="card-body p-3">
                            <div class="small text-muted mb-1 text-truncate">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                {{ $p->district ?? $p->city }}
                            </div>

                            <h5 class="fw-bold mb-2 text-truncate">
                                <a href="{{ route('user.property.show', $p) }}"
                                   class="text-dark text-decoration-none stretched-link">
                                    {{ $p->name }}
                                </a>
                            </h5>

                            <div class="mb-3">
                                <span class="text-primary fw-bold fs-5">
                                    Rp {{ number_format($p->price, 0, ',', '.') }}
                                </span>
                                <small class="text-muted">/ bulan</small>
                            </div>

                            <div class="d-flex flex-wrap gap-1">
                                @foreach(array_slice($p->facilities ?? [], 0, 3) as $fac)
                                    <span class="badge bg-light border text-secondary fw-normal">{{ $fac }}</span>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5>Tidak ada kos ditemukan</h5>
                    <p class="text-muted">Coba ubah filter pencarian kamu.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.card-hover{
    transition:.2s;
}
.card-hover:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,.1)!important;
}
</style>
@endsection
