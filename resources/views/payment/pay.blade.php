@extends('layouts.app')

@section('title', 'Pembayaran Booking')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            {{-- PAYMENT CARD --}}
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
                <div class="card-body p-4 p-md-5 text-center">
                    
                    {{-- ICON --}}
                    <div class="mb-4">
                        <div class="bg-slate-50 rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check text-slate-800 fs-1"></i>
                        </div>
                    </div>

                    {{-- TEXT --}}
                    <h4 class="fw-bold text-slate-800 mb-2">Konfirmasi Pembayaran</h4>
                    <p class="text-slate-500 mb-4">Selesaikan pembayaran Anda dengan aman melalui gateway pembayaran mitra kami.</p>

                    {{-- DETAIL RINGKAS (Opsional jika data tersedia) --}}
                    <div class="bg-slate-50 rounded-4 p-3 mb-4 border border-slate-100">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-slate-500 small">Metode</span>
                            <span class="text-slate-800 small fw-bold">Midtrans Secure</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-slate-500 small">Status</span>
                            <span class="badge bg-amber-50 text-amber-700 border border-amber-100 rounded-pill px-2">Menunggu Pembayaran</span>
                        </div>
                    </div>

                    {{-- ACTION BUTTON --}}
                    <div class="d-grid gap-2">
                        <button id="pay-button" class="btn btn-slate-800 fw-bold py-3 rounded-pill shadow-slate">
                            <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-link text-slate-400 text-decoration-none small mt-2">
                            Kembali ke Detail Booking
                        </a>
                    </div>
                </div>

                {{-- FOOTER SECURE --}}
                <div class="card-footer bg-slate-50 border-0 py-3 text-center">
                    <small class="text-slate-400">
                        <i class="bi bi-lock-fill me-1"></i> Terenkripsi & Terjamin Keamanannya
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MIDTRANS SCRIPT --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            // Opsional: Tambahkan callback agar user experience lebih baik
            onSuccess: function(result) {
                window.location.href = "{{ route('booking.success') }}"; // Sesuaikan route Anda
            },
            onPending: function(result) {
                location.reload();
            },
            onError: function(result) {
                alert("Pembayaran gagal, silakan coba lagi.");
            },
            onClose: function() {
                console.log('User closed the popup without finishing the payment');
            }
        });
    };
</script>

<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-800: #1e293b;
        --amber-50: #fffbeb;
        --amber-100: #fef3c7;
        --amber-700: #b45309;
    }

    body { background-color: #fcfcfd; }
    .text-slate-800 { color: var(--slate-800); }
    .text-slate-500 { color: var(--slate-500); }
    .text-slate-400 { color: var(--slate-400); }
    .bg-slate-50 { background-color: var(--slate-50); }
    
    .bg-amber-50 { background-color: var(--amber-50); }
    .text-amber-700 { color: var(--amber-700); }
    .border-amber-100 { border-color: var(--amber-100) !important; }

    .btn-slate-800 { background: var(--slate-800); color: white; border: none; transition: 0.2s; }
    .btn-slate-800:hover { background: var(--slate-700); transform: translateY(-2px); color: white; }
    .shadow-slate { box-shadow: 0 10px 15px -3px rgba(30, 41, 59, 0.2); }
</style>
@endsection