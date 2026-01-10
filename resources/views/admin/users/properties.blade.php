@extends('layouts.app')

@section('title', 'Detail Properti Owner')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Properti: {{ $user->name }}</h4>
            <p class="text-muted small mb-0">
                <i class="bi bi-envelope me-1"></i> {{ $user->email }}
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" width="5%">ID</th>
                            <th class="py-3 text-secondary text-uppercase small" width="30%">Info Properti</th>
                            <th class="py-3 text-secondary text-uppercase small" width="20%">Lokasi</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Harga</th>
                            <th class="py-3 text-secondary text-uppercase small text-center" width="10%">Booking</th>
                            <th class="pe-4 py-3 text-secondary text-uppercase small text-end" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $p)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 fw-bold text-muted">#{{ $p->id }}</td>

                            {{-- INFO (FOTO + NAMA) --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- Thumbnail Foto --}}
                                    @php 
                                        $thumb = $p->images->where('is_main', 1)->first() ?? $p->images->first(); 
                                    @endphp
                                    <div class="flex-shrink-0 me-3 bg-light rounded overflow-hidden border" style="width: 60px; height: 40px;">
                                        @if($thumb)
                                            <img src="{{ asset('storage/'.$thumb->file_path) }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-muted small">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="fw-bold text-dark">{{ $p->name }}</span>
                                </div>
                            </td>

                            {{-- LOKASI --}}
                            <td>
                                <div class="text-dark small">{{ $p->district }}</div>
                                <div class="text-muted small">{{ $p->city }}</div>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                <span class="fw-bold text-primary">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                            </td>

                            {{-- JUMLAH BOOKING --}}
                            <td class="text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                    {{ $p->bookings_count ?? 0 }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.properties.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus properti ini secara permanen? Data booking terkait juga mungkin akan terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus Properti">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-3 mb-3">
                                        <i class="bi bi-houses fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">Belum ada properti</h6>
                                    <p class="small text-muted mb-0">Owner ini belum menambahkan kosan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection