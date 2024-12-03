@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile Pengguna</h2>

    {{-- Pesan Sukses dan Error --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form untuk Menampilkan dan Mengedit Profil --}}
    <form action="{{ route('profil.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
        </div>

        {{-- Nomor Handphone --}}
        <div class="form-group">
            <label for="phone_number">Nomor Handphone</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
        </div>

        {{-- Alamat Rumah --}}
        <div class="form-group">
            <label for="address">Alamat Rumah</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
        </div>

        {{-- Foto Profil --}}
        <div class="form-group">
            <label for="profile_picture">Foto Profil</label>
            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
            @if($user->profile_picture)
                <div>
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil" width="100">
                </div>
            @else
                <div>No profile picture available.</div>
            @endif
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="password">Password Baru (opsional)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        {{-- Tombol Simpan Perubahan --}}
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    {{-- Tombol Hapus Profil --}}
    <form action="{{ route('profil.destroy', $user->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Profil</button>
    </form>
</div>
@endsection
