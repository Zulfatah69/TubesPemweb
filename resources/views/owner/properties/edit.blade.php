@extends('layouts.app')

@section('title', 'Edit Properti')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">Edit Properti</h3>
            <p class="text-slate-500 mb-0">Perbarui rincian, alamat, dan manajemen galeri foto kos Anda.</p>
        </div>
        <a href="{{ route('owner.properties.index') }}" class="btn btn-white shadow-sm border-slate-200 text-slate-600 px-4 rounded-pill">
            <i class="bi bi-arrow-left me-2 small"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('owner.properties.update', $property->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            {{-- KOLOM KIRI --}}
            <div class="col-lg-8">
                
                {{-- 1. INFORMASI UMUM --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-pencil-square me-2 text-slate-400"></i>Informasi Properti</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-slate-600">Nama Properti</label>
                            <input type="text" name="name" class="form-control bg-slate-50 border-slate-200 py-2" value="{{ old('name', $property->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-slate-600 d-block mb-3">Tipe Penghuni</label>
                            <div class="row g-2">
                                @foreach(['putra', 'putri', 'campuran'] as $g)
                                <div class="col">
                                    <input type="radio" class="btn-check" name="gender_type" id="gender_{{ $g }}" value="{{ $g }}" 
                                        {{ old('gender_type', $property->gender_type) === $g ? 'checked' : '' }}>
                                    <label class="btn btn-outline-slate w-100 py-2 text-capitalize" for="gender_{{ $g }}">
                                        {{ $g }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-slate-600">Harga per Bulan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-slate-200 text-slate-400 fw-bold">Rp</span>
                                    <input type="number" name="price" class="form-control bg-slate-50 border-slate-200 py-2" value="{{ old('price', $property->price) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-slate-600">Tagline Lokasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-slate-200 text-slate-400"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="location" class="form-control bg-slate-50 border-slate-200 py-2" value="{{ old('location', $property->location) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold small text-slate-600">Deskripsi Properti</label>
                            <textarea name="description" rows="5" class="form-control bg-slate-50 border-slate-200">{{ old('description', $property->description) }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- 2. ALAMAT --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-map me-2 text-slate-400"></i>Alamat Detail</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-slate-500 fw-bold">Provinsi</label>
                                <select id="provinsi" name="province" class="form-select bg-slate-50 border-slate-200" data-old="{{ old('province', $property->province) }}" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-slate-500 fw-bold">Kota/Kabupaten</label>
                                <select id="kota" name="city" class="form-select bg-slate-50 border-slate-200" data-old="{{ old('city', $property->city) }}" required>
                                    <option value="">Pilih Kota/Kab</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-slate-500 fw-bold">Kecamatan</label>
                                <select id="kecamatan" name="district" class="form-select bg-slate-50 border-slate-200" data-old="{{ old('district', $property->district) }}" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label small text-slate-500 fw-bold">Alamat Jalan / No. Rumah</label>
                            <textarea name="address" class="form-control bg-slate-50 border-slate-200" rows="2">{{ old('address', $property->address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 3. FASILITAS --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-stars me-2 text-slate-400"></i>Fasilitas Kos</h6>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $facilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar'];
                            $currentFacilities = $property->facilities ?? [];
                        @endphp
                        <div class="row g-3 mb-4">
                            @foreach($facilities as $f)
                            <div class="col-md-4 col-6">
                                <div class="form-check custom-check">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $f }}" id="fac_{{ $loop->index }}"
                                        {{ in_array($f, old('facilities', $currentFacilities)) ? 'checked' : '' }}>
                                    <label class="form-check-label text-slate-600 small" for="fac_{{ $loop->index }}">
                                        {{ $f }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <label class="form-label fw-bold small text-slate-600">Fasilitas Tambahan</label>
                            <input type="text" name="custom_facilities" class="form-control bg-slate-50 border-slate-200" 
                                   value="{{ old('custom_facilities', is_array($property->custom_facilities) ? implode(',', $property->custom_facilities) : $property->custom_facilities) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="col-lg-4">
                {{-- ACTION CARD --}}
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 2rem; border-radius: 20px; z-index: 10;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-slate-800 w-100 fw-bold py-3 rounded-pill mb-3 shadow-slate">
                            Simpan Perubahan
                        </button>
                        <div class="d-flex align-items-center justify-content-center text-slate-400 small">
                            <i class="bi bi-clock-history me-2"></i>
                            Terakhir diupdate: {{ $property->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                {{-- GALERI FOTO --}}
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-images me-2 text-slate-400"></i>Manajemen Foto</h6>
                    </div>
                    <div class="card-body p-4">
                        {{-- Existing Images --}}
                        @if($property->images && $property->images->count())
                            <div class="row g-2 mb-4">
                                @foreach($property->images as $image)
                                    <div class="col-6">
                                        <div class="photo-item position-relative rounded-3 overflow-hidden border border-slate-100 shadow-sm">
                                            <img src="{{ asset(Storage::url($image->file_path)) }}" class="w-100 object-fit-cover" style="height: 110px;">
                                            
                                            @if($image->is_main)
                                                <span class="position-absolute top-0 start-0 badge bg-slate-800 m-1" style="font-size: 0.6rem;">Utama</span>
                                            @endif
                                            
                                            <div class="photo-overlay position-absolute bottom-0 w-100 d-flex justify-content-center gap-1 p-1 bg-dark bg-opacity-50">
                                                @if(!$image->is_main)
                                                    <button type="submit" form="form-main-{{ $image->id }}" class="btn btn-xs btn-light text-warning px-2" title="Set Utama">
                                                        <i class="bi bi-star-fill small"></i>
                                                    </button>
                                                @endif
                                                <button type="submit" form="form-del-{{ $image->id }}" class="btn btn-xs btn-light text-danger px-2" title="Hapus" onclick="return confirm('Hapus foto ini?')">
                                                    <i class="bi bi-trash small"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="upload-zone border border-dashed border-slate-200 rounded-4 p-3 text-center mb-0 bg-slate-50">
                            <label class="form-label small fw-bold text-slate-600 mb-2 d-block text-start">Tambah Foto Baru</label>
                            <input type="file" name="photos[]" multiple class="form-control form-control-sm border-slate-200">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- HIDDEN FORMS --}}
    @foreach($property->images as $image)
        @if(!$image->is_main)
            <form id="form-main-{{ $image->id }}" action="{{ route('owner.properties.image.main', $image->id) }}" method="POST" class="d-none">
                @csrf @method('PATCH')
            </form>
        @endif
        <form id="form-del-{{ $image->id }}" action="{{ route('owner.properties.image.delete', $image->id) }}" method="POST" class="d-none">
            @csrf @method('DELETE')
        </form>
    @endforeach
</div>

<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
    }

    body { background-color: #fcfcfd; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .bg-slate-50 { background-color: var(--slate-50); }
    .border-slate-200 { border-color: var(--slate-200) !important; }
    .border-slate-50 { border-color: var(--slate-50) !important; }

    /* Buttons */
    .btn-white { background: white; border: 1px solid var(--slate-200); }
    .btn-slate-800 { background: var(--slate-800); color: white; border: none; transition: 0.2s; }
    .btn-slate-800:hover { background: var(--slate-700); transform: translateY(-2px); }
    .shadow-slate { box-shadow: 0 4px 14px 0 rgba(30, 41, 59, 0.25); }
    
    .btn-outline-slate { border-color: var(--slate-200); color: var(--slate-500); background: white; }
    .btn-check:checked + .btn-outline-slate { background: var(--slate-800); border-color: var(--slate-800); color: white; }

    /* Form */
    .form-control:focus, .form-select:focus { border-color: var(--slate-400); box-shadow: none; background: white; }
    .custom-check .form-check-input:checked { background-color: var(--slate-800); border-color: var(--slate-800); }

    /* Photo Management */
    .photo-item .photo-overlay { opacity: 0; transition: 0.2s; }
    .photo-item:hover .photo-overlay { opacity: 1; }
    .upload-zone { border-style: dashed !important; border-width: 2px !important; }
    .btn-xs { padding: 0.1rem 0.4rem; font-size: 0.75rem; border-radius: 4px; }
</style>
@endsection

@push('scripts')
<script>
    const provSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecSelect  = document.getElementById('kecamatan');

    const currentProv = provSelect.dataset.old;
    const currentKota = kotaSelect.dataset.old;
    const currentKec  = kecSelect.dataset.old;

    if (typeof wilayah !== 'undefined') {
        initWilayah();
    }

    function initWilayah() {
        loadProvinsi();
        provSelect.addEventListener('change', () => loadKota(false));
        kotaSelect.addEventListener('change', () => loadKecamatan(false));
    }

    function loadProvinsi() {
        provSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
        wilayah.forEach(w => {
            provSelect.innerHTML += `<option value="${w.prov}">${w.prov}</option>`;
        });
        if (currentProv) {
            provSelect.value = currentProv;
            loadKota(true);
        }
    }

    function loadKota(isInit = false) {
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kab</option>';
        if (!isInit) kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

        const p = wilayah.find(w => w.prov === provSelect.value);
        if (!p) return;

        p.kota.forEach(k => {
            const selected = (isInit && k.nama === currentKota) ? 'selected' : '';
            kotaSelect.innerHTML += `<option value="${k.nama}" ${selected}>${k.nama}</option>`;
        });

        if (isInit && currentKota) loadKecamatan(true);
    }

    function loadKecamatan(isInit = false) {
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        const p = wilayah.find(w => w.prov === provSelect.value);
        if (!p) return;
        const k = p.kota.find(x => x.nama === kotaSelect.value);
        if (!k) return;

        k.kec.forEach(c => {
            const selected = (isInit && c === currentKec) ? 'selected' : '';
            kecSelect.innerHTML += `<option value="${c}" ${selected}>${c}</option>`;
        });
    }
</script>
@endpush