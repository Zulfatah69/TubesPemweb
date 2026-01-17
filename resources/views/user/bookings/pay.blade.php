@extends('layouts.app')

@section('title', 'Pembayaran Booking')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <h4 class="fw-bold mb-3">Pembayaran Booking</h4>

                    <p class="mb-1">{{ $booking->property->name }}</p>
                    <p class="text-muted small mb-3">
                        {{ $booking->property->city }}, {{ $booking->property->district }}
                    </p>

                    <div class="h4 fw-bold mb-4">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>

                    <button id="pay-button" class="btn btn-slate-800 px-5 py-2 rounded-pill fw-bold">
                        Bayar Sekarang
                    </button>

                    <div class="mt-3">
                        <a href="{{ route('user.booking.my') }}" class="text-muted small">
                            Kembali ke riwayat booking
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function () {
            window.location.href = "{{ route('user.booking.my') }}";
        },
        onPending: function () {
            window.location.href = "{{ route('user.booking.my') }}";
        },
        onError: function () {
            alert('Pembayaran gagal');
        }
    });
});
</script>
@endsection
