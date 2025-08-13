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
     * Menyimpan user/admin baru dari form "Hak Akses".
     */
    public function store(Request $request)
    {
        // === PERBAIKAN #1: Gunakan validasi langsung dari Request ===
        // Laravel akan otomatis redirect kembali jika validasi gagal.
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                // Pesan error kustom
                'name.required' => 'Nama tidak boleh kosong.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal harus 8 karakter.',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // === PERBAIKAN #2: Tangkap exception validasi untuk menambahkan 'activeTab' ===
            // Jika validasi gagal, kirim kembali dengan pesan error dan nama tab yang benar.
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('activeTab', 'hakAkses'); // <-- INI YANG MENGIRIM PERINTAH
        }

        // Jika validasi SUKSES, buat admin baru
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin', // Asumsi semua user baru adalah admin
        ]);

        // Redirect kembali dengan pesan sukses dan nama tab
        return redirect()->back()
            ->with('success', 'Admin baru berhasil ditambahkan.')
            ->with('activeTab', 'hakAkses');
    }

    /**
     * Menghapus user/admin.
     */
    public function destroy(User $user)
    {
        // Logika ini sudah benar, hanya menambahkan `activeTab` untuk konsistensi
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