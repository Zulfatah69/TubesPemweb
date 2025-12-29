@extends('layouts.app')

@section('content')

<h4>Booking Saya</h4>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered align-middle">

<thead>
<tr>
<th>Properti</th>
<th>Tanggal Mulai</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($bookings as $b)
<tr>
<td>
{{ $b->property->name ?? '-' }}<br>
<small class="text-muted">
{{ $b->property->city ?? '' }},
{{ $b->property->province ?? '' }}
</small>
</td>

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
<a href="{{ route('user.property.show',$b->property_id) }}" class="btn btn-sm btn-primary">
Detail
</a>
</td>
</tr>
@empty
<tr>
<td colspan="4" class="text-center text-muted">Belum ada booking.</td>
</tr>
@endforelse

</tbody>

</table>

</div>
</div>

@endsection
