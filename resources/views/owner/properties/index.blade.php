@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Properti Saya</h4>

    <a href="{{ route('owner.properties.create') }}" class="btn btn-success">
        + Tambah Properti
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
<div class="card-body">

@if($properties->count())
<table class="table table-bordered">
<thead>
<tr>
<th>Nama</th>
<th>Lokasi</th>
<th>Harga</th>
<th width="160">Aksi</th>
</tr>
</thead>

<tbody>
@foreach($properties as $p)
<tr>
<td>{{ $p->name }}</td>
<td>{{ $p->location }}</td>
<td>Rp {{ number_format($p->price,0,',','.') }}</td>
<td>
<a href="{{ route('owner.properties.edit',$p->id) }}" class="btn btn-warning btn-sm">Edit</a>

<form method="POST" action="{{ route('owner.properties.destroy',$p->id) }}" class="d-inline">
@csrf
@method('DELETE')
<button onclick="return confirm('Hapus properti?')" class="btn btn-danger btn-sm">
Hapus
</button>
</form>

</td>
</tr>
@endforeach
</tbody>
</table>
@else
<p class="text-muted">Belum ada properti.</p>
@endif

</div>
</div>

@endsection
