@extends('layouts.app')

@section('content')
<div class="card mx-auto" style="max-width:500px">
    <div class="card-body">
        <h5>Lengkapi Pendaftaran</h5>

        <form method="POST" action="{{ route('register.complete') }}">
            @csrf

            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label>Kode Verifikasi</label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nama</label>
                <input name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="user">User</option>
                    <option value="owner">Owner</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">
                Daftar
            </button>
        </form>
    </div>
</div>
@endsection
