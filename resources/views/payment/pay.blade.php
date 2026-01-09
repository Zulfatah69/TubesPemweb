@extends('layouts.app')

@section('content')
<h4>Pembayaran Booking</h4>

<button id="pay-button" class="btn btn-primary">
    Bayar Sekarang
</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}');
};
</script>
@endsection
