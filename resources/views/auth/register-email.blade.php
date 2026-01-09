@extends('layouts.app')

@section('content')
<div class="card mx-auto" style="max-width:400px">
    <div class="card-body">

        <h5 class="mb-3">Daftar - Verifikasi Email</h5>

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.send') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <button class="btn btn-primary w-100">
                Kirim Kode
            </button>
        </form>

    </div>
</div>
@endsection
