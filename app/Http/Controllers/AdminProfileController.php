<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function edit()
{
    return view('admin.profile', ['user' => auth()->user()]);
}

public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|confirmed|min:6',
        'photo' => 'nullable|image|max:2048',
    ]);

    $user = auth()->user();
    $user->name = $request->name;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('profile_photos', 'public');
        $user->photo = $path;
    }

     $user->save();

    return back()->with('success', 'Profil berhasil diperbarui.');
}
}
