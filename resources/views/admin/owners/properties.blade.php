@extends('layouts.app')

@section('title', 'Detail Properti Owner')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/properties-owner.css') }}">
@endpush

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Properti: {{ $user->name }}</h4>
            <p class="text-muted small mb-0">Daftar semua kosan yang dimiliki oleh owner ini.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Monitoring
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
                            <th class="py-3 text-secondary text-uppercase small" width="30%">Nama Properti</th>
                            <th class="py-3 text-secondary text-uppercase small" width="20%">Lokasi</th>
                            <th class="py-3 text-secondary text-uppercase small" width="15%">Harga</th>
                            <th class="py-3 text-secondary text-uppercase small text-center" width="10%">Foto</th>
                            <th class="pe-4 py-3 text-secondary text-uppercase small text-end" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $p)
                        <tr>
                            {{-- ID --}}
                            <td class="ps-4 fw-bold text-muted">#{{ $p->id }}</td>

                            {{-- NAMA --}}
                            <td>
                                <span class="fw-bold text-dark">{{ $p->name }}</span>
                            </td>

                            {{-- LOKASI --}}
                            <td>
                                <div class="small text-dark">{{ $p->district }}</div>
                                <div class="small text-muted">{{ $p->city }}</div>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                <span class="fw-bold text-primary">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                            </td>

                            {{-- FOTO (COUNT) --}}
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                    <i class="bi bi-images me-1 text-secondary"></i> {{ $p->images->count() }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.properties.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus properti ini secara permanen? Data tidak bisa dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus Properti">
                                        <i class="bi bi-trash-fill me-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="bg-light rounded-circle p-3 mb-3">
                                        <i class="bi bi-houses-fill fs-1 text-muted opacity-50"></i>
                                    </div>
                                    <h6 class="text-muted">Owner ini belum memiliki properti</h6>
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
@endsection