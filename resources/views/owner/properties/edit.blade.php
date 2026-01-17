@extends('layouts.app')

@section('title', 'Edit Properti')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text">Edit Properti</h4>
            <p class="text-muted small mb-0">Perbarui informasi, alamat, dan foto kosan.</p>
        </div>
        <a href="{{ route('owner.properties.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- FORM UTAMA --}}
    <form method="POST" action="{{ route('owner.properties.update', $property->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            {{-- KOLOM KIRI: DATA PROPERTI --}}
            <div class="col-lg-8">
                
                {{-- 1. INFORMASI UMUM --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style="color: #5f666e;"><i class="bi bi-pencil-square me-2"></i>Informasi Umum</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Nama Properti</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $property->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted d-block">Kategori Kos</label>
                            <div class="btn-group w-100" role="group">
                                @foreach(['putra', 'putri', 'campuran'] as $g)
                                    <input type="radio" class="btn-check" name="gender_type" id="gender_{{ $g }}" value="{{ $g }}" 
                                        {{ old('gender_type', $property->gender_type) === $g ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary text-capitalize fw-medium" for="gender_{{ $g }}">
                                        {{ ucfirst($g) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted">Harga / Bulan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold text-secondary">Rp</span>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', $property->price) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted">Lokasi Singkat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="location" class="form-control" value="{{ old('location', $property->location) }}" placeholder="Contoh: Dekat Kampus UNPAD" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold small text-muted">Deskripsi Lengkap</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $property->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. ALAMAT LENGKAP --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style="color: #5f666e;;"><i class="bi bi-map me-2"></i>Alamat Detail</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-muted fw-bold">Provinsi</label>
                                <select id="provinsi"
                                    name="province"
                                    class="form-select"
                                    data-old="{{ old('province', $property->province) }}"
                                    required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-muted fw-bold">Kota/Kabupaten</label>
                                <select id="kota"
                                    name="city"
                                    class="form-select"
                                    data-old="{{ old('city', $property->city) }}"
                                    required>
                                    <option value="">Pilih Kota/Kab</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted fw-bold">Kecamatan</label>
                                <select id="kecamatan"
                                    name="district"
                                    class="form-select"
                                    data-old="{{ old('district', $property->district) }}"
                                    required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label small text-muted fw-bold">Alamat Jalan / Nomor Rumah</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Jl. Mawar No. 12, RT/RW...">{{ old('address', $property->address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 3. FASILITAS --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style="color: #5f666e;;"><i class="bi bi-stars me-2"></i>Fasilitas</h6>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $facilities = ['AC','WiFi','Kamar Mandi Dalam','Parkir','Lemari','Meja','Kursi','Dapur'];
                            $currentFacilities = $property->facilities ?? [];
                        @endphp
                        
                        <div class="row g-3 mb-3">
                            @foreach($facilities as $f)
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $f }}" id="fac_{{ $loop->index }}"
                                            {{ in_array($f, old('facilities', $currentFacilities)) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="fac_{{ $loop->index }}">
                                            {{ $f }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <label class="form-label fw-bold small text" style="color: #5f666e;;">Fasilitas Tambahan</label>
                            <input type="text" name="custom_facilities" class="form-control" 
                                   placeholder="Pisahkan dengan koma (cth: TV, Kulkas)"
                                   value="{{ old('custom_facilities', is_array($property->custom_facilities) ? implode(',', $property->custom_facilities) : $property->custom_facilities) }}">
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: FOTO & ACTIONS --}}
            <div class="col-lg-4">
                
                {{-- TOMBOL SIMPAN (Sticky) --}}
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px; z-index: 10;">
    <div class="card-body p-3">
        <button class="btn w-100 fw-bold py-2" 
                style="background-color: #9AA6B2; color: #ffffff; border: none; box-shadow: none;">
            <i class="bi bi-save me-2"></i> Simpan Perubahan
        </button>
    </div>
</div>


                {{-- MANAJEMEN FOTO --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style="color: #5f666e;;"><i class="bi bi-images me-2"></i>Galeri Foto</h6>
                    </div>
                    <div class="card-body p-3">
                        
                        {{-- List Foto Existing --}}
                        @if($property->images && $property->images->count())
                            <div class="row g-2 mb-3">
                                @foreach($property->images as $image)
                                    <div class="col-6">
                                        <div class="card border h-100 position-relative overflow-hidden">
                                            <img src="{{ asset('storage/' . $image->file_path) }}" 
                                                class="card-img-top h-100 object-fit-cover" 
                                                style="height: 100px;">
                                            {{-- Badge jika foto utama --}}
                                            @if($image->is_main)
                                                <span class="position-absolute top-0 start-0 badge bg-success m-1 shadow-sm" style="font-size: 0.65rem;">Utama</span>
                                            @endif
                                            
                                            {{-- Tombol Aksi Foto --}}
                                            <div class="position-absolute bottom-0 w-100 bg-dark bg-opacity-50 p-1 d-flex justify-content-center gap-2">
                                                @if(!$image->is_main)
                                                    <button type="submit" form="form-main-{{ $image->id }}" class="btn btn-sm btn-light py-0 px-1" title="Jadikan Utama" style="font-size: 0.7rem;">
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    </button>
                                                @endif
                                                <button type="submit" form="form-del-{{ $image->id }}" class="btn btn-sm btn-light py-0 px-1" title="Hapus" style="font-size: 0.7rem;" onclick="return confirm('Hapus foto ini?')">
                                                    <i class="bi bi-trash text-danger"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3 bg-light rounded mb-3">
                                <small>Belum ada foto.</small>
                            </div>
                        @endif

                        <hr class="opacity-25">

                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Upload Foto Baru</label>
                            <input type="file" name="photos[]" multiple class="form-control form-control-sm">
                            <div class="form-text small">Format: JPG, PNG. Bisa pilih banyak.</div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- HIDDEN FORMS UNTUK AKSI FOTO --}}
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
@endsection

@push('scripts')
<script>
    const provSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecSelect  = document.getElementById('kecamatan');

    const currentProv = provSelect.dataset.old;
    const currentKota = "{{ old('city', $property->city) }}";
    const currentKec  = "{{ old('district', $property->district) }}";

    if (typeof wilayah === 'undefined') {
        console.error('wilayah.js belum termuat');
    } else {
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
        }

        if (provSelect.value) {
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

        if (isInit && currentKota) {
            loadKecamatan(true);
        }
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
<style>
    /* Style default untuk kategori radio button: transparan, border abu */
.btn-group .btn-check + .btn {
    background-color: transparent;   /* transparan */
    color: #5F666E;                  /* teks abu */
    border: 1px solid #9AA6B2;       /* border abu */
}

/* Saat tombol dipilih */
.btn-group .btn-check:checked + .btn {
    background-color: transparent;   /* tetap transparan */
    border-color: #415879;           /* border tema */
    color: #415879;                  /* teks ikut border */
}

/* Hover efek: hanya border berubah */
.btn-group .btn-check + .btn:hover {
    background-color: transparent;   /* tetap transparan */
    border-color: #415879;           /* border tema */
    color: #415879;                  /* teks ikut border */
}

</style>
@endpush