@extends('layouts.app')

@section('title', 'Tambah Properti')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">Tambah Properti</h3>
            <p class="text-slate-500 mb-0">Lengkapi detail di bawah untuk mendaftarkan kosan baru Anda.</p>
        </div>
        <a href="{{ route('owner.properties.index') }}" class="btn btn-white shadow-sm border-slate-200 text-slate-600 px-4 rounded-pill">
            <i class="bi bi-x-lg me-2 small"></i> Batal
        </a>
    </div>

    <form method="POST" action="{{ route('owner.properties.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            
            {{-- KOLOM KIRI (UTAMA) --}}
            <div class="col-lg-8">
                
                {{-- 1. INFORMASI UMUM --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-info-circle me-2 text-slate-400"></i>Informasi Umum</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-slate-600">Nama Properti</label>
                            <input type="text" name="name" class="form-control bg-slate-50 border-slate-200 py-2" placeholder="Contoh: Kost Exclusive Mentari" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-slate-600 d-block mb-3">Tipe Penghuni</label>
                            <div class="row g-2">
                                @foreach(['putra', 'putri', 'campuran'] as $g)
                                <div class="col">
                                    <input type="radio" class="btn-check" name="gender_type" id="gender_{{ $g }}" value="{{ $g }}" required>
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
                                    <input type="number" name="price" class="form-control bg-slate-50 border-slate-200 py-2" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold small text-slate-600">Tagline Lokasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-slate-200 text-slate-400"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="location" class="form-control bg-slate-50 border-slate-200 py-2" placeholder="Cth: 5 Menit dari UNPAD" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold small text-slate-600">Deskripsi Properti</label>
                            <textarea name="description" rows="5" class="form-control bg-slate-50 border-slate-200" placeholder="Ceritakan kelebihan properti Anda..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. ALAMAT --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-geo me-2 text-slate-400"></i>Lokasi Presisi</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-slate-500 fw-bold">Provinsi</label>
                                <select id="provinsi" name="province" class="form-select bg-slate-50 border-slate-200" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small text-slate-500 fw-bold">Kota/Kabupaten</label>
                                <select id="kota" name="city" class="form-select bg-slate-50 border-slate-200" required>
                                    <option value="">Pilih Kota/Kab</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-slate-500 fw-bold">Kecamatan</label>
                                <select id="kecamatan" name="district" class="form-select bg-slate-50 border-slate-200" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label small text-slate-500 fw-bold">Alamat Lengkap</label>
                            <textarea name="address" class="form-control bg-slate-50 border-slate-200" rows="2" placeholder="Nama jalan, nomor bangunan, RT/RW..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- 3. FASILITAS --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-grid me-2 text-slate-400"></i>Fasilitas Kos</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            @php $facilities = ['WiFi','AC','Kamar mandi dalam','Parkir Motor','Parkir Mobil','Dapur','Kasur','Lemari','Meja belajar']; @endphp
                            @foreach($facilities as $f)
                            <div class="col-md-4 col-6">
                                <div class="form-check custom-check">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $f }}" id="fac_{{ $loop->index }}">
                                    <label class="form-check-label text-slate-600 small" for="fac_{{ $loop->index }}">
                                        {{ $f }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <label class="form-label fw-bold small text-slate-600">Fasilitas Tambahan</label>
                            <input type="text" name="custom_facilities" class="form-control bg-slate-50 border-slate-200" placeholder="Pisahkan dengan koma (cth: CCTV, Token Listrik, Laundry)">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (SIDEBAR) --}}
            <div class="col-lg-4">
                
                {{-- ACTIONS --}}
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 2rem; border-radius: 20px; z-index: 10;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-slate-800 w-100 fw-bold py-3 rounded-pill mb-3 shadow-slate">
                            Simpan Properti
                        </button>
                        <p class="text-center text-slate-400 small mb-0 px-2">
                            Pastikan data sudah benar sebelum mempublikasikan properti Anda.
                        </p>
                    </div>
                </div>

                {{-- MEDIA --}}
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-header bg-white py-3 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-700"><i class="bi bi-camera me-2 text-slate-400"></i>Galeri Foto</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="upload-zone border border-dashed border-slate-200 rounded-4 p-4 text-center mb-3 bg-slate-50">
                            <i class="bi bi-images display-6 text-slate-200 mb-3 d-block"></i>
                            <input type="file" name="photos[]" multiple class="form-control form-control-sm border-slate-200" required>
                        </div>
                        <ul class="text-slate-400 small ps-3 mb-0">
                            <li>Format: JPG, PNG, WEBP.</li>
                            <li>Bisa pilih banyak foto sekaligus.</li>
                            <li>Gunakan foto berkualitas tinggi.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </form>
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
    .bg-slate-50 { background-color: var(--slate-50); }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-600 { color: var(--slate-600); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .border-slate-200 { border-color: var(--slate-200) !important; }

    .btn-white { background: white; border: 1px solid var(--slate-200); }
    .btn-white:hover { background: var(--slate-50); color: var(--slate-800); }

    /* Custom Radio Buttons */
    .btn-outline-slate {
        border-color: var(--slate-200);
        color: var(--slate-500);
        font-weight: 500;
        background: white;
    }
    .btn-check:checked + .btn-outline-slate {
        background-color: var(--slate-800);
        border-color: var(--slate-800);
        color: white;
    }

    /* Primary Button */
    .btn-slate-800 {
        background-color: var(--slate-800);
        color: white;
        border: none;
        transition: all 0.2s;
    }
    .btn-slate-800:hover {
        background-color: var(--slate-700);
        transform: translateY(-2px);
    }
    .shadow-slate { box-shadow: 0 4px 14px 0 rgba(30, 41, 59, 0.25); }

    /* Form Styling */
    .form-control:focus, .form-select:focus {
        border-color: var(--slate-400);
        box-shadow: none;
        background-color: white;
    }

    .custom-check .form-check-input:checked {
        background-color: var(--slate-800);
        border-color: var(--slate-800);
    }

    .upload-zone { border-style: dashed !important; border-width: 2px !important; }
</style>
@endsection

@push('scripts')
<script>
    // Logic Wilayah tetap dipertahankan
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
@endpush