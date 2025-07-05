<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $messages = [];

        // Update nama
        if ($user->name !== $request->name) {
            $user->name = $request->name;
            $messages[] = 'Nama berhasil diperbarui';
        }

        // Validasi manual password
        if ($request->filled('password') || $request->filled('password_confirmation')) {

            // Jika salah satu kosong
            if (empty($request->password) || empty($request->password_confirmation)) {
                return back()->with('error', 'Masukkan password dan konfirmasi password!');
            }

            // Jika password tidak sama
            if ($request->password !== $request->password_confirmation) {
                return back()->with('error', 'Masukkan password yang benar!');
            }

            // Cek panjang password
            if (strlen($request->password) < 6) {
                return back()->with('error', 'Masukkan password minimal 6 karakter');
            }

            // Cek apakah password sama dengan password lama
            if (Hash::check($request->password, $user->password)) {
                return back()->with('error', 'Masukkan password yang baru ya!');
            }

            $user->password = bcrypt($request->password);
            $messages[] = 'Password berhasil diperbarui';
        }

        // Update foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
            $messages[] = 'Profil berhasil diperbarui';
        }

        $user->save();

        if (empty($messages)) {
            $messages[] = 'Tidak ada perubahan';
        }

        if (count($messages) > 1) {
            $messages = ['Profil berhasil diperbarui'];
        }

        return back()->with('success', implode('. ', $messages) . '.');
    }
}
