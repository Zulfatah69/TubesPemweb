@extends('layouts.app')

@section('title','Booking Masuk')

@section('content')

<nav class="navbar navbar-dark bg-success">
 <div class="container">
    <span class="navbar-brand">Booking Masuk</span>

    <a href="{{ route('owner.dashboard') }}" class="btn btn-outline-light btn-sm">
        ← Dashboard Pemilik
    </a>
 </div>
</nav>

<div class="container py-4">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered align-middle">
<thead>
<tr>
 <th>Pemesan</th>
 <th>Properti</th>
 <th>Tanggal</th>
 <th>Status</th>
 <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($bookings as $b)

<tr>
 <td>{{ $b->user->name }}</td>

 <td>{{ $b->property->name }}</td>

 <td>{{ $b->start_date }}</td>

 <td>
    @if($b->status=='pending')
        <span class="badge bg-warning text-dark">Menunggu</span>
    @elseif($b->status=='approved')
        <span class="badge bg-success">Diterima</span>
    @else
        <span class="badge bg-danger">Ditolak</span>
    @endif
 </td>

 <td>
    @if($b->status=='pending')

    <form method="POST" action="{{ route('owner.booking.update',[$b->id,'approved']) }}" class="d-inline">
        @csrf
        <button class="btn btn-success btn-sm">Terima</button>
    </form>

    <form method="POST" action="{{ route('owner.booking.update',[$b->id,'rejected']) }}" class="d-inline">
        @csrf
        <button class="btn btn-danger btn-sm">Tolak</button>
    </form>

    @else
        -
    @endif
 </td>

</tr>

@empty
<tr>
 <td colspan="5" class="text-center text-muted">
    Belum ada booking.
 </td>
</tr>
@endforelse

</tbody>

</table>

</div>
</div>

</div>

@endsection
