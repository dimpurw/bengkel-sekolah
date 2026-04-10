<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ClassRoomController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('classRoom')
            ->where('role', 'walikelas')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('class', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'identity_number' => 'required|string|max:50',
            'password' => ['required', Password::min(8)],
            'class_room' => 'required|string|unique:class_rooms,nama', // wajib & unik
        ]);

        DB::beginTransaction();

        try {
            $classRoom = ClassRoom::create([
                'nama' => $request->class_room
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'identity_number' => $request->identity_number,
                'password' => Hash::make($request->password),
                'role' => 'walikelas',
                'class_room_id' => $classRoom->id,
            ]);

            DB::commit();

            return redirect()->route('class.index')
                ->with('success', 'Data Master Kelas berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'identity_number' => 'required|string|max:50',
            'password' => ['nullable', Password::min(8)],
            'class_room' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $user->classRoom->update([
                'nama' => $request->class_room
            ]);

            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'identity_number' => $request->identity_number,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            DB::commit();

            return redirect()->route('class.index')
                ->with('success', 'Data Master Kelas berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            $classRoom = $user->classRoom;

            // Hapus user
            $user->delete();

            // Hapus class room (jika ada)
            if ($classRoom) {
                $classRoom->delete();
            }

            DB::commit();

            return redirect()->route('class.index')
                ->with('success', 'Data Master Kelas berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
