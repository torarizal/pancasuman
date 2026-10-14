<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan form ubah profil untuk pengguna yang sedang login.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Perbarui data profil pengguna yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        // Jika mengisi password baru, pastikan password saat ini valid
        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        }

        $validated = $request->validate($rules, [
            'current_password.current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'bio' => $validated['bio'] ?? null,
        ];

        // Handle foto profil
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = ImageOptimizer::optimizeAndStore(
                $request->file('avatar'),
                'avatars',
                maxWidth: 400,
                quality: 85
            );
        }

        // Handle ganti password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
