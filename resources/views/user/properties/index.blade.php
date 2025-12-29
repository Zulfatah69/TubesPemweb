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
