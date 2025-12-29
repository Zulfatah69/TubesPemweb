@extends('layouts.app')

@section('content')

{{-- ALERT --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="row">

<div class="col-md-7">

    {{-- CAROUSEL FOTO --}}
    @if($property->images && $property->images->count())
    <div id="carouselPhotos" class="carousel slide mb-3" data-bs-ride="carousel">
        
        <div class="carousel-inner">

            @foreach($property->images as $index => $img)
            <div class="carousel-item {{ $index==0?'active':'' }}">
                <img src="{{ asset('storage/'.$img->file_path) }}" class="d-block w-100 rounded">
            </div>
            @endforeach

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPhotos" data-bs-slide="prev">
         <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselPhotos" data-bs-slide="next">
         <span class="carousel-control-next-icon"></span>
        </button>

    </div>
    @else
    <p class="text-muted">Belum ada foto</p>
    @endif

</div>


<div class="col-md-5">

    <div class="card shadow-sm">
    <div class="card-body">

        <h3>{{ $property->name }}</h3>

        <div class="text-muted mb-2">
            {{ $property->address }}<br>
            {{ $property->district }}, {{ $property->city }}<br>
            {{ $property->province }}
        </div>

        <div class="fs-4 text-success fw-bold">
            Rp {{ number_format($property->price,0,',','.') }}/bulan
        </div>

        <hr>

        <h6>Fasilitas</h6>

        @if($property->facilities)
            @foreach($property->facilities as $f)
                <span class="badge bg-primary">{{ $f }}</span>
            @endforeach
        @else
            <p class="text-muted">Tidak ada fasilitas default</p>
        @endif

        @if($property->custom_facilities)
        <h6 class="mt-3">Fasilitas Tambahan</h6>

            @foreach($property->custom_facilities as $f)
                <span class="badge bg-secondary">{{ $f }}</span>
            @endforeach
        @endif

        <hr>

        <h6>Deskripsi</h6>

        <p>{{ $property->description ?? 'Tidak ada deskripsi' }}</p>

        <hr>

        {{-- FORM BOOKING --}}
        <form method="POST" action="{{ route('user.booking.store', $property->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tanggal Mulai Sewa</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="note" class="form-control" rows="2"></textarea>
            </div>

            <button class="btn btn-success w-100">
                Ajukan Sewa
            </button>

        </form>

        <small class="text-muted">
            Pengajuan akan dikirim ke pemilik. Status bisa dilihat di menu "Booking Saya".
        </small>

    </div>
    </div>

</div>

</div>

@endsection
