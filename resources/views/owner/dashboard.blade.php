@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h3>Dashboard Pemilik</h3>
    <div class="mb-3">
        <a href="{{ route('owner.chats') }}" class="btn btn-primary">
            💬 Chat Masuk
            @if(isset($totalChats))
                <span class="badge bg-light text-dark">{{ $totalChats }}</span>
            @endif
        </a>
    </div>
    <div class="row mt-3">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $total_properties }}</h4>
                    <p class="text-muted">Total Properti</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $total_bookings }}</h4>
                    <p class="text-muted">Total Booking Masuk</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>{{ $pending_bookings }}</h4>
                    <p class="text-muted">Menunggu Konfirmasi</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
