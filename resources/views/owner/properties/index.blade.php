@extends('layouts.app')

@section('title', 'Kelola Properti')

@section('content')
<div class="container py-5">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">Daftar Properti</h3>
            <p class="text-slate-500 mb-0">Kelola dan pantau performa seluruh unit kos Anda di satu tempat.</p>
        </div>
        <a href="{{ route('owner.properties.create') }}" class="btn btn-slate-800 fw-bold px-4 py-2 rounded-pill shadow-slate">
            <i class="bi bi-plus-lg me-2"></i>Tambah Properti
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="card-body p-0">
            
            @if($properties->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-slate-50 border-bottom border-slate-100">
                        <tr>
                            <th class="ps-4 py-3 text-slate-500 text-uppercase fw-bold small" style="width: 40%;">Unit Properti</th>
                            <th class="py-3 text-slate-500 text-uppercase fw-bold small">Area</th>
                            <th class="py-3 text-slate-500 text-uppercase fw-bold small">Harga Sewa</th>
                            <th class="pe-4 py-3 text-end text-slate-500 text-uppercase fw-bold small">Manajemen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $p)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center">
                                    {{-- Thumbnail Logic --}}
                                    @php 
                                        $thumb = $p->images->where('is_main', 1)->first() ?? $p->images->first(); 
                                    @endphp
                                    
                                    <div class="flex-shrink-0 rounded-4 overflow-hidden border border-slate-100 shadow-sm" style="width: 90px; height: 65px;">
                                        @if($thumb)
                                            <img src="{{ asset('storage/'.$thumb->file_path) }}" class="w-100 h-100 object-fit-cover" alt="Property">
                                        @else
                                            <div class="w-100 h-100 bg-slate-100 d-flex align-items-center justify-content-center text-slate-400">
                                                <i class="bi bi-image fs-4"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ms-3">
                                        <div class="fw-bold text-slate-800 mb-1">{{ $p->name }}</div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge rounded-pill bg-emerald-50 text-emerald-700 border border-emerald-100 small px-2">
                                                <i class="bi bi-check-circle-fill me-1" style="font-size: 0.7rem;"></i> Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="text-slate-700 fw-medium mb-1">{{ $p->district }}</div>
                                <div class="small text-slate-400"><i class="bi bi-geo-alt me-1"></i>{{ $p->city }}</div>
                            </td>

                            <td>
                                <div class="fw-bold text-slate-800">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                                <div class="small text-slate-400">per bulan</div>
                            </td>

                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('owner.properties.edit', $p->id) }}" class="btn btn-action-edit" title="Ubah Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST" action="{{ route('owner.properties.destroy', $p->id) }}" class="d-inline" onsubmit="return confirm('Hapus properti ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-action-delete" title="Hapus Properti">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if(method_exists($properties, 'links'))
                <div class="p-4 bg-slate-50 border-top border-slate-100">
                    {{ $properties->links() }}
                </div>
            @endif

            @else
            {{-- EMPTY STATE --}}
            <div class="text-center py-5">
                <div class="mb-4">
                    <div class="bg-slate-50 rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                        <i class="bi bi-house-add text-slate-300 display-4"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-slate-800">Etalase Masih Kosong</h4>
                <p class="text-slate-500 mb-5 mx-auto" style="max-width: 400px;">Anda belum mendaftarkan properti. Daftarkan kosan Anda sekarang untuk mulai menjangkau ribuan calon penyewa.</p>
                <a href="{{ route('owner.properties.create') }}" class="btn btn-slate-800 px-5 py-3 rounded-pill fw-bold shadow-slate">
                    Daftarkan Unit Pertama
                </a>
            </div>
            @endif

        </div>
    </div>
</div>

<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --emerald-50: #ecfdf5;
        --emerald-100: #d1fae5;
        --emerald-700: #047857;
    }

    body { background-color: #fcfcfd; font-family: 'Inter', sans-serif; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-700 { color: var(--slate-700); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .text-slate-300 { color: var(--slate-300); }
    .bg-slate-50 { background-color: var(--slate-50); }
    .bg-emerald-50 { background-color: var(--emerald-50); }
    .text-emerald-700 { color: var(--emerald-700); }
    .border-emerald-100 { border-color: var(--emerald-100) !important; }

    .btn-slate-800 { background: var(--slate-800); color: white; border: none; transition: 0.2s; }
    .btn-slate-800:hover { background: var(--slate-700); transform: translateY(-2px); }
    .shadow-slate { box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2); }

    /* Custom Action Buttons */
    .btn-action-edit {
        background: white;
        border: 1px solid var(--slate-200);
        color: var(--slate-600);
        padding: 0.5rem 0.75rem;
        border-radius: 12px;
        transition: 0.2s;
    }
    .btn-action-edit:hover {
        background: var(--slate-800);
        color: white;
        border-color: var(--slate-800);
    }

    .btn-action-delete {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #e11d48;
        padding: 0.5rem 0.75rem;
        border-radius: 12px;
        transition: 0.2s;
    }
    .btn-action-delete:hover {
        background: #e11d48;
        color: white;
        border-color: #e11d48;
    }

    .table th { letter-spacing: 0.025em; }
    .table td { border-bottom: 1px solid var(--slate-50); }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection