@extends('layouts.app')

@section('content')

<h4>Edit Properti</h4>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('owner.properties.update',$property->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="mb-3">
<label>Nama Properti</label>
<input type="text" name="name" class="form-control" value="{{ $property->name }}" required>
</div>

<div class="mb-3">
<label>Lokasi Singkat</label>
<input type="text" name="location" class="form-control" value="{{ $property->location }}" required>
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
<input type="text" name="address" class="form-control" value="{{ $property->address }}">
</div>

<hr>

<div class="mb-3">
<label>Harga / Bulan</label>
<input type="number" name="price" class="form-control" value="{{ $property->price }}" required>
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="description" class="form-control">{{ $property->description }}</textarea>
</div>

<hr>

<h6>Fasilitas</h6>

@php
$defaultFacilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar'];
$selected = $property->facilities ?? [];
@endphp

<div class="row">
@foreach($defaultFacilities as $f)
<div class="col-md-4">
<label>
<input type="checkbox" name="facilities[]" value="{{ $f }}" {{ in_array($f,$selected)?'checked':'' }}>
{{ $f }}
</label>
</div>
@endforeach
</div>

<div class="mt-3">
<label>Fasilitas tambahan</label>
<input type="text" name="custom_facilities" class="form-control"
value="{{ $property->custom_facilities ? implode(',',$property->custom_facilities):'' }}">
</div>

<hr>

<h6>Foto yang sudah ada</h6>

@if($property->images && $property->images->count())
<div class="row mb-3">
@foreach($property->images as $img)
<div class="col-md-3 text-center mb-3">

<img src="{{ asset('storage/'.$img->file_path) }}" class="img-fluid rounded mb-1">

@if($img->is_main)
<div class="badge bg-success mb-1 w-100">Foto Utama</div>
@else
<form method="POST" action="{{ route('owner.properties.image.setMain',$img->id) }}" class="mb-1">
@csrf
<button class="btn btn-outline-primary btn-sm w-100">Jadikan Foto Utama</button>
</form>
@endif

<form method="POST" action="{{ route('owner.properties.image.delete',$img->id) }}"
onsubmit="return confirm('Hapus foto ini?')">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm w-100">Hapus</button>
</form>

</div>
@endforeach
</div>
@else
<p class="text-muted">Belum ada foto.</p>
@endif

<hr>

<div class="mb-3">
<label>Tambah Foto Baru</label>
<input type="file" name="photos[]" class="form-control" multiple>
</div>

<button class="btn btn-success">Update</button>
<a href="{{ route('owner.properties.index') }}" class="btn btn-secondary">Batal</a>

</form>

<script>
// wilayah sama seperti halaman tambah…
</script>

@endsection
