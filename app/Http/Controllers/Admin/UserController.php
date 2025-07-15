<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan halaman manajemen user/admin.
     */
    public function index()
    {
        // Ambil semua user yang memiliki role 'admin'
        $admins = User::where('role', 'admin')->get();
        
        // Kita akan membuat view-nya di langkah berikutnya
        return view('admin.users.index', compact('admins'));
    }

    /**
     * Menyimpan user/admin baru.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Langsung set rolenya sebagai admin
        ]);

       // PERUBAHAN DI SINI: Arahkan kembali ke halaman profil
        return redirect()->route('admin.profile')->with('success', 'Admin baru berhasil ditambahkan.');
    }


    /**
     * Menghapus user/admin.
     */
    public function destroy(User $user)
    {
        // Tambahkan pengaman agar user tidak bisa menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.profile')->with('success', 'Admin berhasil dihapus.');
    }
}