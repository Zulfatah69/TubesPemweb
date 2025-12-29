@extends('layouts.app')

@section('content')

<h4>Cari Kos</h4>

@include('user.search-form') {{-- filter yang sudah kamu buat --}}

@include('user.property-list') {{-- daftar kos --}}

@endsection
