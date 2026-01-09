@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Bayar Booking</h5>
        <p>Total: <strong>Rp {{ number_format($booking->total_price) }}</strong></p>

        <button id="pay-button" class="btn btn-success">
            Bayar Sekarang
        </button>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}');
};
</script>
@endsection
