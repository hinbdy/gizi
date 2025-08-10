<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menyimpan user/admin baru dari form "Hak Akses".
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        // Jika validasi GAGAL, kembali dengan error dan nama tab yang benar
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('activeTab', 'hakAkses'); // <-- INI YANG MENGIRIM PERINTAH
        }

        // Jika validasi SUKSES, buat admin baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()
            ->with('success', 'Admin baru berhasil ditambahkan.')
            ->with('activeTab', 'hakAkses');
    }

    /**
     * Menghapus user/admin.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.')
                ->with('activeTab', 'hakAkses');
        }

        $user->delete();

        return redirect()->back()
            ->with('success', 'Admin berhasil dihapus.')
            ->with('activeTab', 'hakAkses');
    }
}