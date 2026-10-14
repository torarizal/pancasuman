<?php

namespace App\Http\Controllers\Admin\Developer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna/akun di sistem.
     */
    public function index(Request $request)
    {
        $query = User::withCount('posts')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('developer.users.index', compact('users'));
    }

    /**
     * Tampilkan form pembuatan akun baru.
     */
    public function create()
    {
        return view('developer.users.create');
    }

    /**
     * Simpan akun baru beserta role-nya ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['developer', 'admin', 'penulis'])],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'bio' => $validated['bio'] ?? null,
        ]);

        return redirect()->route('admin.developer.users.index')
            ->with('success', "Akun '{$validated['name']}' dengan peran [{$validated['role']}] berhasil ditambahkan!");
    }

    /**
     * Form edit akun pengguna.
     */
    public function edit(User $user)
    {
        return view('developer.users.edit', compact('user'));
    }

    /**
     * Update akun pengguna dan role-nya.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['developer', 'admin', 'penulis'])],
            'password' => ['nullable', 'string', 'min:6'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'bio' => $validated['bio'] ?? null,
        ];

        // Jika developer mengisi reset password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.developer.users.index')
            ->with('success', "Data akun '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Hapus akun pengguna (dilindungi: tidak bisa menghapus diri sendiri).
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.developer.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.developer.users.index')
            ->with('success', "Akun '{$name}' telah berhasil dihapus dari sistem.");
    }
}
