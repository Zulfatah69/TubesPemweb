@extends('layouts.app')

@section('title', 'Tambah Properti')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/add-property.css') }}">
@endpush

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text" style= "color: #5F666E;">Tambah Properti</h4>
            <p class="text-muted small mb-0">Isi form di bawah untuk menambahkan kosan baru.</p>
        </div>
        <a href="{{ route('owner.properties.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Batal
        </a>
    </div>

    <form method="POST" action="{{ route('owner.properties.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            
            {{-- KOLOM KIRI --}}
            <div class="col-lg-8">
                
                {{-- 1. INFORMASI UMUM --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style= "color: #5F666E;"><i class="bi bi-pencil-square me-2" style= "color: #5F666E;"></i>Informasi Umum</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Nama Properti</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Kost Melati Indah" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted d-block">Kategori Kos</label>
                            <div class="btn-group w-100" role="group">
                                @foreach(['putra', 'putri', 'campuran'] as $g)
                                    <input type="radio" class="btn-check" name="gender_type" id="gender_{{ $g }}" value="{{ $g }}" required>
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
                                    <input type="number" name="price" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-muted">Lokasi Singkat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="location" class="form-control" placeholder="Dekat Kampus X" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold small text-muted">Deskripsi Lengkap</label>
                            <textarea name="description" rows="4" class="form-control" placeholder="Jelaskan fasilitas dan keunggulan kos..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. ALAMAT LENGKAP --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style= "color: #5F666E;"><i class="bi bi-map me-2" style= "color: #5F666E;"></i>Alamat Detail</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-muted fw-bold">Provinsi</label>
                                <select id="provinsi" name="province" class="form-select" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-muted fw-bold">Kota/Kabupaten</label>
                                <select id="kota" name="city" class="form-select" required>
                                    <option value="">Pilih Kota/Kab</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted fw-bold">Kecamatan</label>
                                <select id="kecamatan" name="district" class="form-select" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        {{-- Field Alamat Jalan (Tambahan agar lengkap) --}}
                        <div>
                            <label class="form-label small text-muted fw-bold">Alamat Jalan / Nomor Rumah</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Jl. Mawar No. 12, RT/RW..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- 3. FASILITAS --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style= "color: #5F666E;"><i class="bi bi-stars me-2" style= "color: #5F666E;"></i>Fasilitas</h6>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $facilities = ['AC','WiFi','Kamar Mandi Dalam','Parkir','Lemari','Meja','Kursi','Dapur'];
                        @endphp
                        
                        <div class="row g-3 mb-3">
                            @foreach($facilities as $f)
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $f }}" id="fac_{{ $loop->index }}">
                                        <label class="form-check-label small" for="fac_{{ $loop->index }}">
                                            {{ $f }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <label class="form-label fw-bold small text-muted">Fasilitas Tambahan</label>
                            <input type="text" name="custom_facilities" class="form-control" placeholder="Pisahkan dengan koma (cth: CCTV, Laundry)">
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="col-lg-4">
                
                {{-- TOMBOL SIMPAN (Sticky) --}}
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="color: top: 20px; z-index: 10;">
                    <div class="card-body p-3">
                        <button class="btn btn-success w-100 fw-bold py-2" style="background-color: #9AA6B2; color: white; outline: none; box-shadow: none; border: none;" >
                            <i class="bi bi-plus-lg me-2"></i> Simpan Properti
                        </button>
                    </div>
                </div>

                {{-- UPLOAD FOTO --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold" style= "color: #5F666E;"><i class="bi bi-images me-2"></i>Upload Foto</h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-cloud-arrow-up display-4 text-muted opacity-25"></i>
                        </div>
                        <input type="file" name="photos[]" multiple class="form-control form-control-sm mb-2" required>
                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                            Format: JPG, PNG. Bisa pilih banyak sekaligus.
                        </small>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const provSelect = document.getElementById('provinsi');
    const kotaSelect = document.getElementById('kota');
    const kecSelect = document.getElementById('kecamatan');

    if(typeof wilayah !== 'undefined') {
        loadProvinsi();
    }

    function loadProvinsi() {
        provSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
        wilayah.forEach(w => {
            provSelect.innerHTML += `<option value="${w.prov}">${w.prov}</option>`;
        });
    }

    provSelect.addEventListener('change', function() {
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kab</option>';
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        
        const p = wilayah.find(w => w.prov === this.value);
        if(!p) return;

        p.kota.forEach(k => {
            kotaSelect.innerHTML += `<option value="${k.nama}">${k.nama}</option>`;
        });
    });

    kotaSelect.addEventListener('change', function() {
        kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        
        const p = wilayah.find(w => w.prov === provSelect.value);
        if(!p) return;
        
        const k = p.kota.find(x => x.nama === this.value);
        if(!k) return;
        
        k.kec.forEach(c => {
            kecSelect.innerHTML += `<option value="${c}">${c}</option>`;
        });
    });
</script>

<style>
/* Style untuk gender radio button */
.btn-group .btn-check:checked + .btn {
    background-color: #415879; /* warna tema saat dipilih */
    border-color: #415879;     /* ganti warna border */
    color: white;              /* teks putih */
}

.btn-group .btn {
    border-color: #9AA6B2;    /* warna border default */
    color: #5F666E;            /* teks default */
}

/* Saat hover */
.btn-group .btn:hover {
    border-color: #415879;
    color: grey;
}
</style>
@endpush