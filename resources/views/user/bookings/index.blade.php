@extends('layouts.app')

@section('content')

<h4 class="mb-4">Booking Saya</h4>

@if($bookings->count() == 0)
    <div class="alert alert-info">
        Belum ada booking.
    </div>
@endif

@foreach($bookings as $booking)
<div class="card mb-3">
    <div class="card-body">

        <h5>{{ $booking->property->name }}</h5>

        <p class="mb-1">
            Mulai Sewa: <strong>{{ $booking->start_date }}</strong>
        </p>

        <p class="mb-1">
            Status Booking:
            <span class="badge bg-secondary">
                {{ strtoupper($booking->status) }}
            </span>
        </p>

        <p class="mb-1">
            Status Pembayaran:
            @if($booking->payment_status === 'paid')
                <span class="badge bg-success">LUNAS</span>
            @elseif($booking->payment_status === 'failed')
                <span class="badge bg-danger">GAGAL</span>
            @else
                <span class="badge bg-warning text-dark">BELUM BAYAR</span>
            @endif
        </p>

        <p class="mt-2">
            Total:
            <strong class="text-success">
                Rp {{ number_format($booking->total_price,0,',','.') }}
            </strong>
        </p>

        {{-- TOMBOL BAYAR --}}
        @if($booking->payment_status === 'unpaid')
            <a href="{{ route('booking.pay', $booking->id) }}"
               class="btn btn-primary btn-sm">
                💳 Bayar Sekarang
            </a>
        @endif

    </div>
</div>
@endforeach

@endsection
