<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfilController extends Controller
{
    // Menampilkan daftar pengguna (Read All)
    public function index()
    {
        $users = User::all();
        return view('profil.index', compact('users'));
    }

    // Menampilkan form untuk menambah pengguna baru (Create)
    public function create()
    {
        return view('profil.create');
    }

    // Menyimpan data pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        // Menyimpan foto profil jika ada
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Menyimpan nomor handphone jika ada
        $user->phone_number = $request->input('phone_number');
        $user->save();

        return redirect()->route('profil.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit profil pengguna (Edit)
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Cek jika pengguna yang sedang login adalah pengguna yang sedang diedit
        if (Auth::id() !== $user->id && Auth::user()->role_id !== 1) { // role_id 1 untuk admin
            return redirect()->route('profil.index')->with('error', 'Anda tidak dapat mengedit profil pengguna lain!');
        }

        return view('profil.edit', compact('user'));
    }

    // Memperbarui profil pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Cek jika pengguna yang sedang login adalah pengguna yang sedang diperbarui
        if (Auth::id() !== $user->id && Auth::user()->role_id !== 1) { // role_id 1 untuk admin
            return redirect()->route('profil.index')->with('error', 'Anda tidak dapat memperbarui profil pengguna lain!');
        }

        // Validasi dan proses pembaruan data...
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update nama dan email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Jika password diubah, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Menyimpan foto profil baru jika ada
        if ($request->hasFile('profile_picture')) {
            // Hapus foto profil lama jika ada
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Simpan foto profil baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        // Menyimpan nomor handphone baru jika ada
        $user->phone_number = $request->input('phone_number');
        $user->save();

        return redirect()->route('profil.show', ['id' => $id])->with('success', 'Profil berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cek jika pengguna yang sedang login adalah pengguna yang akan dihapus
        if (Auth::id() !== $user->id && Auth::user()->role_id !== 1) { // role_id 1 untuk admin
            return redirect()->route('profil.index')->with('error', 'Anda tidak dapat menghapus pengguna lain!');
        }

        // Hapus foto profil jika ada
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Hapus pengguna
        $user->delete();

        return redirect()->route('homes.home')->with('success', 'Pengguna berhasil dihapus!');
    }

    // Menampilkan detail profil pengguna berdasarkan ID (Show)
    public function show($id)
    {
        $user = User::findOrFail($id);  // Ambil data pengguna berdasarkan ID
        return view('profil.show', compact('user'));  // Kirim data pengguna ke view 'profil.show'
    }
}
