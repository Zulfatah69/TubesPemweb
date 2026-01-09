@extends('layouts.app')

@section('content')

<div class="card mx-auto" style="max-width: 500px;">
    <div class="card-body text-center">

        <h5>Verifikasi Email</h5>
        <p class="text-muted">
            Kami sudah mengirim link verifikasi ke email kamu.
        </p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-primary">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

    </div>
</div>

@endsection
