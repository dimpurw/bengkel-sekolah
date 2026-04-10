<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        $classRooms = ClassRoom::orderBy('created_at', 'desc')
            ->get();

        return view('user', compact('users', 'classRooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username',
            'identity_number' => 'required|string|max:50',
            'foto'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'password'        => ['required', Password::min(8)],
            'class_room_id'   => 'required|exists:class_rooms,id',
        ]);

        // ── Upload foto hero
        $fotoPath = $school->foto ?? null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoPath = 'user_folder/foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('user_folder', $fotoPath);
        }

        User::create([
            'name'            => $request->name,
            'username'        => $request->username,
            'identity_number' => $request->identity_number,
            'foto'            => $fotoPath,
            'password'        => Hash::make($request->password),
            'role'            => 'user',
            'class_room_id'   => $request->class_room_id,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'Data Master Siswa berhasil dibuat');
    }

    public function detail($id)
    {
        $s = User::with('classRoom')->where('role', 'user')->findOrFail($id);

        return response()->json([
            'siswa' => [
                'id'                   => $s->id,
                'name'                 => $s->name,
                'identity_number'      => $s->identity_number,
                'class_room'           => $s->classRoom->nama ?? '-',
                'class_room_id'        => $s->class_room_id,
                'username'             => $s->username ?? '-',
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'username'        => 'required|string|max:255|unique:users,username,' . $user->id,
            'identity_number' => 'required|string|max:50',
            'foto'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'password'        => ['nullable', Password::min(8)],
            'class_room_id'   => 'required|exists:class_rooms,id',
        ]);

        // ── Upload foto hero
        $fotoPath = $user->foto ?? null;

        if ($request->hasFile('foto')) {
            if ($user && $user->foto) {
                unlink($user->foto);
            }

            $file = $request->file('foto');
            $fotoPath = 'user_folder/foto_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('user_folder', $fotoPath);
        }

        $data = [
            'name'            => $request->name,
            'username'        => $request->username,
            'identity_number' => $request->identity_number,
            'foto'            => $fotoPath,
            'password'        => Hash::make($request->password),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')
            ->with('success', 'Data Master Siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user && $user->foto) {
            unlink($user->foto);
        }

        // Hapus user
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'Data Master Siswa berhasil dihapus');
    }
}
