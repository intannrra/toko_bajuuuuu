<form action="{{ route('profil.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Menggunakan metode PUT untuk update data -->

    <div>
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div>
        <label for="phone_number">Nomor Telepon:</label>
        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
    </div>

    <div>
        <label for="password">Password (kosongkan jika tidak diubah):</label>
        <input type="password" id="password" name="password">
    </div>

    <div>
        <label for="password_confirmation">Konfirmasi Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <div>
        <label for="profile_picture">Foto Profil:</label>
        <input type="file" id="profile_picture" name="profile_picture">
    </div>

    <button type="submit">Simpan Perubahan</button>
</form>
