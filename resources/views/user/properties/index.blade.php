<<<<<<< HEAD
<!doctype html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cari Kos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
 <div class="container">
    <span class="navbar-brand">Cari Kos</span>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-light btn-sm">Logout</button>
    </form>
 </div>
</nav>

<div class="container py-4">

<h4>Filter Pencarian</h4>

<form method="GET" class="card card-body shadow-sm mb-4">

<div class="row">
<div class="col-md-3">
<label>Provinsi</label>
<select id="provinsi" name="province" class="form-select"></select>
</div>

<div class="col-md-3">
<label>Kota</label>
<select id="kota" name="city" class="form-select"></select>
</div>

<div class="col-md-3">
<label>Kecamatan</label>
<select id="kecamatan" name="district" class="form-select"></select>
</div>

<div class="col-md-3">
<label>Harga Maks</label>
<select name="max_price" class="form-select">
<option value="">Semua</option>
<option value="500000" {{ request('max_price')=='500000'?'selected':'' }}>≤ 500rb</option>
<option value="1000000" {{ request('max_price')=='1000000'?'selected':'' }}>≤ 1 Juta</option>
<option value="2000000" {{ request('max_price')=='2000000'?'selected':'' }}>≤ 2 Juta</option>
</select>
</div>
</div>

<hr>

<h6>Fasilitas</h6>

@php
$facilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil'];
$selectedFacilities = request('facility',[]);
@endphp

<div class="row">
@foreach($facilities as $f)
<div class="col-md-3">
<label>
<input type="checkbox" name="facility[]" value="{{ $f }}"
    {{ in_array($f,$selectedFacilities)?'checked':'' }}>
 {{ $f }}
</label>
</div>
@endforeach
</div>

<hr>

<button class="btn btn-primary">Terapkan Filter</button>

</form>


<h4>Hasil Pencarian</h4>

<div class="row">

@forelse($properties as $p)
<div class="col-md-4 mb-3">

    <div class="card shadow-sm">

        <a href="{{ route('user.property.show',$p->id) }}">
            @php
                $img = $p->images->first();
            @endphp

            @if($img)
            <img src="{{ asset('storage/'.$img->file_path) }}" class="card-img-top">
            @endif
        </a>

        <div class="card-body">
            <h5>
                <a href="{{ route('user.property.show',$p->id) }}" class="text-decoration-none">
                    {{ $p->name }}
                </a>
            </h5>

            <div class="text-muted">
                {{ $p->city }},
                {{ $p->province }}
            </div>

            <div class="fw-bold text-success">
                Rp {{ number_format($p->price,0,',','.') }}/bulan
            </div>

            <p class="small text-muted">
                {{ $p->location }}
            </p>

            @if($p->facilities)
            <span class="badge bg-light text-dark">
                {{ implode(', ', $p->facilities) }}
            </span>
            @endif
        </div>
    </div>

</div>
@empty

<p class="text-muted">Tidak ada kos ditemukan</p>

@endforelse

</div>

</div>


<script>
// ===== Contoh data wilayah sederhana =====
const wilayah = [
 {prov:'Jawa Barat', kota:[
     {nama:'Bandung', kec:['Coblong','Sukajadi','Cidadap']},
     {nama:'Bekasi', kec:['Bekasi Selatan','Bekasi Barat']}
 ]},
 {prov:'DKI Jakarta', kota:[
     {nama:'Jakarta Selatan', kec:['Kebayoran Lama','Tebet']},
     {nama:'Jakarta Barat', kec:['Grogol','Palmerah']}
 ]}
];

const prov=document.getElementById('provinsi');
const kota=document.getElementById('kota');
const kec=document.getElementById('kecamatan');

const selectedProv = "{{ request('province') }}";
const selectedKota = "{{ request('city') }}";
const selectedKec  = "{{ request('district') }}";

// ===== PROVINSI =====
prov.innerHTML='<option value="">Semua</option>';

wilayah.forEach(w=>{
    prov.innerHTML += `<option value="${w.prov}" ${w.prov===selectedProv?'selected':''}>${w.prov}</option>`;
});

loadKota();
loadKecamatan();

prov.onchange = loadKota;
kota.onchange = loadKecamatan;


// ===== KOTA =====
function loadKota(){
    kota.innerHTML='<option value="">Semua</option>';
    kec.innerHTML='<option value="">Semua</option>';

    const p = wilayah.find(x=>x.prov===prov.value);
    if(!p) return;

    p.kota.forEach(k=>{
        kota.innerHTML += `<option value="${k.nama}" ${k.nama===selectedKota?'selected':''}>${k.nama}</option>`;
    });

    loadKecamatan();
}

// ===== KECAMATAN =====
function loadKecamatan(){
    kec.innerHTML='<option value="">Semua</option>';

    const p = wilayah.find(x=>x.prov===prov.value);
    if(!p) return;

    const k = p.kota.find(x=>x.nama===kota.value);
    if(!k) return;

    k.kec.forEach(c=>{
        kec.innerHTML += `<option value="${c}" ${c===selectedKec?'selected':''}>${c}</option>`;
    });
}
</script>

</body>
</html>
=======
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 90px; z-index: 100;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-funnel"></i> Filter
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('user.dashboard') }}">
                    
                    {{-- LOKASI --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold text-uppercase">Lokasi</label>
                        <select id="provinsi" name="province" class="form-select form-select-sm mb-2"></select>
                        <select id="kota" name="city" class="form-select form-select-sm mb-2"></select>
                        <select id="kecamatan" name="district" class="form-select form-select-sm"></select>
                    </div>

                    <hr class="text-muted opacity-25">

                    {{-- HARGA --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold text-uppercase">Harga Maksimal</label>
                        <select name="max_price" class="form-select form-select-sm">
                            <option value="">Semua Harga</option>
                            <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>Rp 500rb</option>
                            <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>Rp 1 Juta</option>
                            <option value="2000000" {{ request('max_price') == '2000000' ? 'selected' : '' }}>Rp 2 Juta</option>
                            <option value="3000000" {{ request('max_price') == '3000000' ? 'selected' : '' }}>Rp 3 Juta</option>
                        </select>
                    </div>

                    <hr class="text-muted opacity-25">

                    {{-- KATEGORI KOS --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold text-uppercase">Kategori Kos</label>
                        <select name="gender_type" class="form-select form-select-sm">
                            <option value="">Semua</option>
                            <option value="putra" {{ request('gender_type') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('gender_type') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campuran" {{ request('gender_type') == 'campuran' ? 'selected' : '' }}>Campuran</option>
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
                        
                        <div class="d-flex flex-column gap-2">
                            @foreach($facilities as $f)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="facility[]" value="{{ $f }}"
                                        {{ in_array($f, $selectedFacilities) ? 'checked' : '' }}>
                                    <label class="form-check-label small">{{ $f }}</label>
                                </div>
                            @endforeach
                        </div>
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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Rekomendasi Kos</h4>
            <span class="text-muted small">Menampilkan {{ count($properties) }} hasil</span>
        </div>

        <div class="row g-4">
            @forelse($properties as $p)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm card-hover">

                    {{-- IMAGE --}}
                    <div class="position-relative">
                        <a href="{{ route('user.property.show', $p->id) }}">
                            @php $img = $p->images->first(); @endphp
                            <img src="{{ $img ? asset('storage/'.$img->file_path) : 'https://placehold.co/600x400?text=No+Image' }}"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        </a>

                        {{-- BADGE KATEGORI --}}
                        @php
                            $badgeClass = match($p->gender_type){
                                'putra' => 'primary',
                                'putri' => 'danger',
                                'campuran' => 'success',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeClass }} position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
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
                            <a href="{{ route('user.property.show', $p->id) }}" class="text-dark text-decoration-none stretched-link">
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
>>>>>>> zulfatah
