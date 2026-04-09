<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $school = School::first() ?? new School();

        return view('school', compact('school'));
    }

    public function update(Request $request)
    {
        $school = School::first();

        $request->validate([
            'nama_sekolah'    => 'required',
            'npsn'            => 'required',
            'provinsi'        => 'required',
            'kota'            => 'required',
            'tahun_ajaran'    => 'required',
            'nama_bengkel'    => 'required',
            'nama_kepsek'     => 'required',
            'nip_kepsek'      => 'required',
            'foto_kepsek'     => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'nama_kabeng'     => 'required',
            'nip_kabeng'      => 'required',
            'foto_kabeng'     => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'logo'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
        ]);

        // ── Upload foto hero
        $logoPath = $school->logo ?? null;

        if ($request->hasFile('logo')) {
            if ($school && $school->logo) {
                unlink($school->logo);
            }

            $file = $request->file('logo');
            $logoPath = 'school_folder/logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('school_folder', $logoPath);
        }

        $fotoKepsekPath = $school->foto_kepsek ?? null;

        if ($request->hasFile('foto_kepsek')) {
            if ($school && $school->foto_kepsek) {
                unlink($school->foto_kepsek);
            }

            $file = $request->file('foto_kepsek');
            $fotoKepsekPath = 'school_folder/fotokepsek_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('school_folder', $fotoKepsekPath);
        }

        $fotoKabengPath = $school->foto_kabeng ?? null;

        if ($request->hasFile('foto_kabeng')) {
            if ($school && $school->foto_kabeng) {
                unlink($school->foto_kabeng);
            }

            $file = $request->file('foto_kabeng');
            $fotoKabengPath = 'school_folder/fotokabeng_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('school_folder', $fotoKabengPath);
        }

        School::updateOrCreate((['id' => 1]), [
            'nama_sekolah'     => $request->nama_sekolah,
            'npsn'             => $request->npsn,
            'provinsi'         => $request->provinsi,
            'kota'             => $request->kota,
            'tahun_ajaran'     => $request->tahun_ajaran,
            'nama_bengkel'     => $request->nama_bengkel,
            'nama_kepsek'      => $request->nama_kepsek,
            'nip_kepsek'       => $request->nip_kepsek,
            'foto_kepsek'      => $fotoKepsekPath,
            'nama_kabeng'      => $request->nama_kabeng,
            'nip_kabeng'       => $request->nip_kabeng,
            'foto_kabeng'      => $fotoKabengPath,
            'logo'             => $logoPath,
        ]);


        return redirect()->route('school.index')->with('success', 'Data Identitas Sekolah berhasil diperbarui!');
    }
}
