<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StafController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'staf')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staf', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username',
            'identity_number' => 'required|string|max:50',
            'wa'              => 'required|string|max:50',
            'foto'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'password'        => ['required', Password::min(8)],
        ]);

        // ── Upload foto hero
        $fotoPath = $school->foto ?? null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoPath = 'staf_folder/foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('staf_folder', $fotoPath);
        }

        User::create([
            'name'            => $request->name,
            'username'        => $request->username,
            'identity_number' => $request->identity_number,
            'wa'              => $request->wa,
            'foto'            => $fotoPath,
            'password'        => Hash::make($request->password),
            'role'            => 'staf',
        ]);

        return redirect()->route('staf.index')
            ->with('success', 'Data Master Staf Bengkel berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username,' . $user->id,
            'identity_number' => 'required|string|max:50',
            'wa'              => 'required|string|max:50',
            'foto'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'password'        => ['nullable', Password::min(8)],
        ]);

        // ── Upload foto hero
        $fotoPath = $user->foto ?? null;

        if ($request->hasFile('foto')) {
            if ($user && $user->foto) {
                unlink($user->foto);
            }

            $file = $request->file('foto');
            $fotoPath = 'staf_folder/foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('staf_folder', $fotoPath);
        }

        $data = [
            'name'            => $request->name,
            'username'        => $request->username,
            'identity_number' => $request->identity_number,
            'wa'              => $request->wa,
            'foto'            => $fotoPath,
            'password'        => Hash::make($request->password),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('staf.index')
            ->with('success', 'Data Master Staf Bengkel berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user && $user->foto) {
            unlink($user->foto);
        }

        // Hapus user
        $user->delete();

        return redirect()->route('staf.index')
            ->with('success', 'Data Master Staf Bengkel berhasil dihapus');
    }
}
