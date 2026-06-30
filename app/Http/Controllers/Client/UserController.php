<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan data profile user yang sedang login.
     */
    public function index()
    {
        $user = auth()->user();
        return view('pages.client.user.index', compact('user'));
    }

    /**
     * Menampilkan form edit profile (email tidak bisa diubah).
     */
    public function edit()
    {
        $user = auth()->user();
        return view('pages.client.user.edit', compact('user'));
    }

    /**
     * Update profile user yang sedang login (kecuali email).
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
        ];

        // Password hanya divalidasi jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)->update($data);

        return redirect()->route('client.user.index')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}
