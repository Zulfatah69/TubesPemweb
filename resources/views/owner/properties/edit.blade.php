@extends('layouts.app')

@section('title', 'Edit Properti')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Properti</h4>
            <p class="text-muted small mb-0">Perbarui informasi kos</p>
        </div>
        <a href="{{ route('owner.properties.index') }}" class="btn btn-outline-secondary btn-sm">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('owner.properties.update', $property->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">

                {{-- INFORMASI --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Nama Properti</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $property->name) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Kos</label><br>
                            @foreach(['putra','putri','campuran'] as $g)
                                <label class="me-3">
                                    <input type="radio"
                                           name="gender_type"
                                           value="{{ $g }}"
                                           {{ old('gender_type', $property->gender_type) === $g ? 'checked' : '' }}
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
                                       value="{{ old('price', $property->price) }}"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi Singkat</label>
                                <input type="text"
                                       name="location"
                                       class="form-control"
                                       value="{{ old('location', $property->location) }}"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description"
                                      class="form-control">{{ old('description', $property->description) }}</textarea>
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
                                        data-old="{{ old('province', $property->province) }}"
                                        required>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kota / Kabupaten</label>
                                <select id="kota"
                                        name="city"
                                        class="form-select"
                                        data-old="{{ old('city', $property->city) }}"
                                        required>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Kecamatan</label>
                                <select id="kecamatan"
                                        name="district"
                                        class="form-select"
                                        data-old="{{ old('district', $property->district) }}"
                                        required>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address"
                                      class="form-control">{{ old('address', $property->address) }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <input type="file" name="photos[]" multiple class="form-control mb-3">
                <button class="btn btn-success w-100">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
