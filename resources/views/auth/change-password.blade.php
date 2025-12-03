@extends('layouts.app')
@section('title','Ganti Password')
@section('content')
<div style="max-width:400px;margin:20px auto;">
    <h3 style="color:#c62828;">Ganti Password</h3>
    @if(session('success'))
        <div style="background:#d4edda;padding:10px;border-radius:5px;margin-bottom:10px;color:#155724;">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('change-password') }}">
        @csrf
        <label>Password Lama</label>
        <input type="password" name="current_password" required style="width:100%;padding:10px;margin-bottom:10px;">
        <label>Password Baru</label>
        <input type="password" name="new_password" required style="width:100%;padding:10px;margin-bottom:10px;">
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation" required style="width:100%;padding:10px;margin-bottom:10px;">
        <button type="submit" style="background:#c62828;color:white;padding:10px;width:100%;border:none;border-radius:5px;">Simpan</button>
    </form>
</div>
@endsection
