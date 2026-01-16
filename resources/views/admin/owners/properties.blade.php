@extends('layouts.app')

@section('title', 'Properti Owner')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h4 class="fw-bold">Properti: {{ $owner->name }}</h4>
        <p class="text-muted mb-0">
            Total Properti: {{ $properties->total() }}
        </p>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($properties as $property)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $property->name }}</td>
                            <td>{{ $property->city }}, {{ $property->province }}</td>
                            <td>Rp {{ number_format($property->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($property->images->first())
                                    <img src="{{ asset('storage/'.$property->images->first()->file_path) }}"
                                         width="80" class="rounded">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.properties.destroy', $property->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus properti?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Owner ini belum punya properti
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $properties->links() }}
    </div>

</div>
@endsection
