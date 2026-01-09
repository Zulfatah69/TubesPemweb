@extends('layouts.app')

@section('title', 'Kelola Properti')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Properti Saya</h4>
            <p class="text-muted small mb-0">Kelola daftar kosan yang Anda sewakan.</p>
        </div>
        <a href="{{ route('owner.properties.create') }}" class="btn btn-primary fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tambah Properti
        </a>
    </div>

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            
            @if($properties->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" style="width: 40%;">Info Properti</th>
                            <th class="py-3 text-secondary text-uppercase small">Lokasi</th>
                            <th class="py-3 text-secondary text-uppercase small">Harga Sewa</th>
                            <th class="pe-4 py-3 text-end text-secondary text-uppercase small">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $p)
                        <tr>
                            {{-- KOLOM INFO (FOTO + NAMA) --}}
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    {{-- Logic Foto Thumbnail --}}
                                    @php 
                                        $thumb = $p->images->where('is_main', 1)->first() ?? $p->images->first(); 
                                    @endphp
                                    
                                    <div class="flex-shrink-0 position-relative overflow-hidden rounded border" style="width: 80px; height: 60px;">
                                        @if($thumb)
                                            <img src="{{ asset('storage/'.$thumb->file_path) }}" class="w-100 h-100 object-fit-cover" alt="Foto">
                                        @else
                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ms-3">
                                        <div class="fw-bold text-dark">{{ $p->name }}</div>
                                        <div class="small text-muted">
                                            <i class="bi bi-door-open me-1"></i> Tersedia
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- KOLOM LOKASI --}}
                            <td>
                                <div class="text-dark">{{ $p->district }}</div>
                                <small class="text-muted">{{ $p->city }}</small>
                            </td>

                            {{-- KOLOM HARGA --}}
                            <td>
                                <span class="fw-bold text-primary">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                                <span class="small text-muted">/bln</span>
                            </td>

                            {{-- KOLOM AKSI --}}
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('owner.properties.edit', $p->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form method="POST" action="{{ route('owner.properties.destroy', $p->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus properti ini? Data yang dihapus tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus Properti">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION (JIKA ADA) --}}
            @if(method_exists($properties, 'links'))
                <div class="p-3 border-top">
                    {{ $properties->links() }}
                </div>
            @endif

            @else
            {{-- EMPTY STATE (JIKA KOSONG) --}}
            <div class="text-center py-5">
                <div class="mb-3">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-building-add fs-1 text-muted opacity-50"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-dark">Belum Ada Properti</h5>
                <p class="text-muted mb-4">Mulai sewakan kosanmu dan temukan penyewa dengan mudah.</p>
                <a href="{{ route('owner.properties.create') }}" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Properti Baru
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    /* Agar gambar thumbnail tidak gepeng */
    .object-fit-cover {
        object-fit: cover;
    }
</style>

@endsection
