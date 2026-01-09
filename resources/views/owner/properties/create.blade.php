@extends('layouts.app')

<<<<<<< HEAD
@section('content')

<h4>Tambah Properti</h4>

<form method="POST" action="{{ route('owner.properties.store') }}" enctype="multipart/form-data">
@csrf

<div class="mb-3">
<label>Nama Properti</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Lokasi Singkat</label>
<input type="text" name="location" class="form-control" required>
</div>

<hr>

<h6>Alamat Detail</h6>

<div class="row">
<div class="col-md-4 mb-3">
<label>Provinsi</label>
<select id="provinsi" name="province" class="form-select" required></select>
</div>

<div class="col-md-4 mb-3">
<label>Kota/Kabupaten</label>
<select id="kota" name="city" class="form-select" required></select>
</div>

<div class="col-md-4 mb-3">
<label>Kecamatan</label>
<select id="kecamatan" name="district" class="form-select" required></select>
</div>
</div>

<div class="mb-3">
<label>Alamat Lengkap</label>
<input type="text" name="address" class="form-control">
</div>

<hr>

<div class="mb-3">
<label>Harga / Bulan</label>
<input type="number" name="price" class="form-control" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="description" class="form-control"></textarea>
</div>

<hr>

<h6>Fasilitas (bisa difilter)</h6>

@php
$defaultFacilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar'];
@endphp

<div class="row">
@foreach($defaultFacilities as $f)
<div class="col-md-4">
<label>
<input type="checkbox" name="facilities[]" value="{{ $f }}">
{{ $f }}
</label>
</div>
@endforeach
</div>

<div class="mt-3">
<label>Fasilitas tambahan (pisahkan dengan koma)</label>
<input type="text" name="custom_facilities" class="form-control" placeholder="contoh: TV, Dispenser">
<small class="text-muted">Fasilitas ini tidak ikut filter</small>
</div>

<hr>

<div class="mb-3">
<label>Foto Properti (bisa lebih dari 1)</label>
<input type="file" name="photos[]" class="form-control" multiple>
<small class="text-muted">Foto pertama akan jadi foto utama</small>
</div>

<button class="btn btn-success">Simpan</button>
<a href="{{ route('owner.properties.index') }}" class="btn btn-secondary">Batal</a>

</form>

<script>
// data wilayah sederhana
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

const provSelect=document.getElementById('provinsi');
const kotaSelect=document.getElementById('kota');
const kecSelect=document.getElementById('kecamatan');

provSelect.innerHTML='<option value="">Pilih Provinsi</option>';
wilayah.forEach(w=>provSelect.innerHTML+=`<option>${w.prov}</option>`);

provSelect.onchange=()=>{
 kotaSelect.innerHTML='';
 kecSelect.innerHTML='';
 const p=wilayah.find(w=>w.prov===provSelect.value);
 if(!p) return;
 p.kota.forEach(k=>kotaSelect.innerHTML+=`<option>${k.nama}</option>`);
 kotaSelect.onchange();
};

kotaSelect.onchange=()=>{
 kecSelect.innerHTML='';
 const p=wilayah.find(w=>w.prov===provSelect.value);
 if(!p) return;
 const k=p.kota.find(x=>x.nama===kotaSelect.value);
 if(!k) return;
 k.kec.forEach(c=>kecSelect.innerHTML+=`<option>${c}</option>`);
};
</script>

=======
@section('title', 'Tambah Properti')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Tambah Properti Baru</h4>
            <p class="text-muted small mb-0">Isi informasi kos yang akan disewakan</p>
        </div>
        <a href="{{ route('owner.properties.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('owner.properties.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">

                {{-- INFORMASI DASAR --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Nama Properti</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Kos</label><br>
                            @foreach(['putra','putri','campuran'] as $g)
                                <label class="me-3">
                                    <input type="radio"
                                           name="gender_type"
                                           value="{{ $g }}"
                                           {{ old('gender_type') === $g ? 'checked' : '' }}
                                           required>
                                    {{ ucfirst($g) }}
                                </label>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga / Bulan</label>
                                <input type="number"
                                       name="price"
                                       class="form-control"
                                       value="{{ old('price') }}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Singkat</label>
                                <input type="text"
                                       name="location"
                                       class="form-control"
                                       value="{{ old('location') }}"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description"
                                      class="form-control">{{ old('description') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Provinsi</label>
                                <select id="provinsi"
                                        name="province"
                                        class="form-select"
                                        data-old="{{ old('province') }}"
                                        required>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kota / Kabupaten</label>
                                <select id="kota"
                                        name="city"
                                        class="form-select"
                                        data-old="{{ old('city') }}"
                                        required>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kecamatan</label>
                                <select id="kecamatan"
                                        name="district"
                                        class="form-select"
                                        data-old="{{ old('district') }}"
                                        required>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address"
                                      class="form-control">{{ old('address') }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <input type="file" name="photos[]" multiple class="form-control">
                    </div>
                </div>

                <button class="btn btn-success w-100">
                    Simpan Properti
                </button>
            </div>
        </div>
    </form>
</div>
>>>>>>> zulfatah
@endsection
